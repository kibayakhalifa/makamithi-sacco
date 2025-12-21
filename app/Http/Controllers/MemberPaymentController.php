<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\ChequeRecord;
use App\Models\SavingsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member');
    }

    /**
     * Display all payments and disbursements for the logged-in member
     */
    public function disbursedPayments()
    {
        $user = Auth::user();
        
        // Get all payments made to this member with pagination
        $payments = Payment::where('user_id', $user->id)
            ->with(['loan' => function($q) {
                $q->select('id', 'loan_number', 'purpose', 'amount as loan_amount');
            }])
            ->orderBy('payment_date', 'desc')
            ->paginate(20);
        
        // Get cheque details for payments that were made by cheque
        $chequeDetails = ChequeRecord::where('user_id', $user->id)
            ->with(['payment'])
            ->get()
            ->keyBy('payment_id');
        
        // Get savings withdrawals (completed withdrawals only)
        $savingsWithdrawals = SavingsTransaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->with(['payment'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(20, ['*'], 'withdrawals_page');
        
        // Get loan disbursements (payments where amount = loan amount - usually the first payment)
        $loanDisbursements = Payment::where('user_id', $user->id)
            ->whereHas('loan', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['loan' => function($q) {
                $q->select('id', 'loan_number', 'purpose', 'amount');
            }])
            ->get()
            ->filter(function($payment) {
                return $payment->loan && $payment->amount == $payment->loan->amount;
            })
            ->values();
        
        // Statistics
        $stats = [
            'total_received' => Payment::where('user_id', $user->id)->sum('amount'),
            'loan_disbursements' => Payment::where('user_id', $user->id)
                ->whereHas('loan', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('loan')
                ->get()
                ->filter(function($payment) {
                    return $payment->loan && $payment->amount == $payment->loan->amount;
                })
                ->sum('amount'),
            'savings_withdrawals' => SavingsTransaction::where('user_id', $user->id)
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->sum('amount'),
            'total_cheques' => ChequeRecord::where('user_id', $user->id)->count(),
            'pending_payments' => Payment::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
        ];
        
        // Group payments by type for summary
        $paymentsByType = [
            'loan_disbursement' => Payment::where('user_id', $user->id)
                ->whereHas('loan', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('loan')
                ->get()
                ->filter(function($payment) {
                    return $payment->loan && $payment->amount == $payment->loan->amount;
                })
                ->count(),
            'loan_repayment_refund' => Payment::where('user_id', $user->id)
                ->where('amount', '>', 0)
                ->whereNotNull('loan_id')
                ->whereHas('loan', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('loan')
                ->get()
                ->filter(function($payment) {
                    return $payment->loan && $payment->amount != $payment->loan->amount;
                })
                ->count(),
            'savings_withdrawal' => SavingsTransaction::where('user_id', $user->id)
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->count(),
            'other' => Payment::where('user_id', $user->id)
                ->whereNull('loan_id')
                ->whereNull('savings_transaction_id')
                ->count(),
        ];
        
        // Payment methods breakdown
        $paymentMethods = Payment::where('user_id', $user->id)
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();
        
        return view('member.payments-disbursed', compact(
            'payments',
            'chequeDetails',
            'savingsWithdrawals',
            'loanDisbursements',
            'stats',
            'paymentsByType',
            'paymentMethods',
            'user'
        ));
    }
    
    /**
     * Show details of a specific payment
     */
    public function showPayment($paymentId)
    {
        $user = Auth::user();
        
        $payment = Payment::where('id', $paymentId)
            ->where('user_id', $user->id)
            ->with([
                'loan' => function($q) {
                    $q->select('id', 'loan_number', 'purpose', 'amount', 'disbursed_date');
                },
                'savingsTransaction',
                'chequeRecord'
            ])
            ->firstOrFail();
        
        // Check if this is a loan disbursement (payment amount equals loan amount)
        $isDisbursement = $payment->loan && $payment->amount == $payment->loan->amount;
        
        return view('member.payment-details', compact('payment', 'isDisbursement'));
    }
    
    /**
     * Get cheque payments specifically
     */
    public function chequePayments()
    {
        $user = Auth::user();
        
        $chequePayments = ChequeRecord::where('user_id', $user->id)
            ->with(['payment' => function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->select('id', 'payment_ref', 'amount', 'payment_date', 'status');
            }])
            ->whereHas('payment')
            ->orderBy('issue_date', 'desc')
            ->paginate(20);
        
        return view('member.cheque-payments', compact('chequePayments'));
    }

    public function create(Loan $loan)
    {
        $this->authorize('view', $loan);
        
        if (!in_array($loan->status, ['active', 'disbursed'])) {
            return redirect()->route('member.loans.show', $loan)
                ->with('error', 'You can only make payments for active loans.');
        }

        return view('member.payments.create', compact('loan'));
    }

    public function store(Request $request, Loan $loan)
    {
        $this->authorize('view', $loan);
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,mpesa,bank,cheque',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);
        
        // Check if amount exceeds remaining balance
        if ($request->amount > $loan->remaining_balance) {
            return redirect()->back()
                ->with('error', 'Payment amount exceeds remaining balance.')
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Create payment record
            $payment = new Payment([
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'payment_ref' => 'PAY-' . time() . rand(100, 999),
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'status' => 'pending', // Member payments need approval
                'posted_by' => Auth::id(),
            ]);
            
            // Calculate principal and interest
            $monthlyInterest = $loan->interest_amount / $loan->period_months;
            $interestPortion = min($request->amount, $monthlyInterest);
            $principalPortion = $request->amount - $interestPortion;
            
            $payment->interest = $interestPortion;
            $payment->principal = $principalPortion;
            $payment->balance_before = $loan->remaining_balance;
            
            $payment->save();
            
            // Create cheque record if payment method is cheque
            if ($request->payment_method === 'cheque' && $request->filled('reference_number')) {
                ChequeRecord::create([
                    'payment_id' => $payment->id,
                    'loan_id' => $loan->id,
                    'user_id' => $loan->user_id,
                    'cheque_number' => $request->reference_number,
                    'bank_name' => 'Member Provided',
                    'bank_branch' => 'N/A',
                    'account_number' => 'N/A',
                    'amount' => $request->amount,
                    'purpose' => 'loan_repayment',
                    'status' => 'pending',
                    'issue_date' => $request->payment_date,
                    'issued_by' => Auth::id(),
                    'issue_notes' => 'Payment submitted by member: ' . ($request->notes ?? 'No notes'),
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('member.loans.show', $loan)
                ->with('success', 'Payment submitted successfully! It will be processed after verification.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error recording payment: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Get payment statistics for dashboard
     */
    public function getPaymentStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total_received' => Payment::where('user_id', $user->id)->sum('amount'),
            'total_payments' => Payment::where('user_id', $user->id)->count(),
            'pending_payments' => Payment::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'recent_payments' => Payment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->orderBy('payment_date', 'desc')
                ->take(5)
                ->get(['payment_ref', 'amount', 'payment_date', 'payment_method']),
        ];
        
        return response()->json($stats);
    }
    
    /**
     * Export payments to CSV
     */
    public function exportPayments(Request $request)
    {
        $user = Auth::user();
        
        $payments = Payment::where('user_id', $user->id)
            ->with(['loan' => function($q) {
                $q->select('id', 'loan_number', 'amount as loan_amount');
            }])
            ->orderBy('payment_date', 'desc')
            ->get();
        
        $filename = "payments-export-" . date('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Date',
                'Reference',
                'Type',
                'Loan Number',
                'Amount',
                'Payment Method',
                'Status',
                'Notes'
            ]);
            
            // CSV data
            foreach ($payments as $payment) {
                $type = 'Other Payment';
                if ($payment->loan) {
                    $type = $payment->amount == $payment->loan->loan_amount 
                        ? 'Loan Disbursement' 
                        : 'Loan Payment';
                } elseif ($payment->savings_transaction_id) {
                    $type = 'Savings Withdrawal';
                }
                
                fputcsv($file, [
                    $payment->payment_date->format('d/m/Y'),
                    $payment->payment_ref,
                    $type,
                    $payment->loan ? $payment->loan->loan_number : 'N/A',
                    $payment->amount,
                    ucfirst($payment->payment_method),
                    ucfirst($payment->status),
                    $payment->notes ?? ''
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}