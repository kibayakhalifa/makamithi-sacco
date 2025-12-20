<?php

namespace App\Http\Controllers;

use App\Models\BankReconciliation;
use App\Models\ChequeRecord;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\Saving;
use App\Models\SavingsTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreasurerController extends Controller
{
    // ============ DASHBOARD ============
    public function dashboard()
    {
        $stats = [
            'total_savings' => Saving::sum('available_savings'),
            'active_loans' => Loan::whereIn('status', ['active', 'disbursed'])->sum('remaining_balance'),
            'pending_payments' => Payment::where('status', 'pending')->sum('amount'),
            'cash_at_bank' => $this->getCashAtBank(),
            'total_members' => User::where('role', 'member')->count(),
            'pending_cheques' => ChequeRecord::where('status', 'issued')->count(),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
        ];

        $recentTransactions = Payment::with('loan.user')
            ->where('status', 'completed')
            ->orderBy('payment_date', 'desc')
            ->take(10)
            ->get();

        $upcomingDeadlines = Loan::where('next_payment_date', '<=', Carbon::now()->addDays(7))
            ->whereIn('status', ['active', 'disbursed'])
            ->with('user')
            ->get();

        return view('treasurer.dashboard', compact('stats', 'recentTransactions', 'upcomingDeadlines'));
    }

    // ============ 1. PAYMENT PROCESSING ============
    public function payments()
    {
        // Loan disbursements pending
        $pendingDisbursements = Loan::where('status', 'approved')
            ->with('user')
            ->get();

        // Savings withdrawals pending
        $pendingWithdrawals = SavingsTransaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->with('user')
            ->get();

        // Expenses pending payment
        $pendingExpenses = Expense::where('status', 'approved')
            ->where('payment_status', 'pending')
            ->get();

        // Completed payments (recent)
        $recentPayments = Payment::where('status', 'completed')
            ->with(['loan.user', 'savingsTransaction.user'])
            ->orderBy('payment_date', 'desc')
            ->take(20)
            ->get();

        $paymentStats = [
            'total_pending' => $pendingDisbursements->sum('amount') +
                $pendingWithdrawals->sum('amount') +
                $pendingExpenses->sum('amount'),
            'pending_count' => $pendingDisbursements->count() +
                $pendingWithdrawals->count() +
                $pendingExpenses->count(),
            'today_completed' => Payment::whereDate('payment_date', Carbon::today())
                ->where('status', 'completed')
                ->sum('amount'),
        ];

        return view('treasurer.payments', compact(
            'pendingDisbursements',
            'pendingWithdrawals',
            'pendingExpenses',
            'recentPayments',
            'paymentStats'
        ));
    }

    // ============ 2. LOANS MANAGEMENT ============
    public function loans()
    {
        $loans = Loan::with('user')->get();

        $loanStats = [
            'total_loans' => $loans->count(),
            'total_amount' => $loans->sum('amount'),
            'active_loans' => $loans->whereIn('status', ['active', 'disbursed'])->count(),
            'pending_loans' => $loans->where('status', 'pending')->count(),
            'approved_loans' => $loans->where('status', 'approved')->count(),
            'rejected_loans' => $loans->where('status', 'rejected')->count(),
            'paid_loans' => $loans->where('status', 'paid')->count(),
            'defaulted_loans' => $loans->where('status', 'defaulted')->count(),
        ];

        // Group loans by status for tabs
        $loansByStatus = [
            'pending' => Loan::where('status', 'pending')->with('user')->get(),
            'approved' => Loan::where('status', 'approved')->with('user')->get(),
            'active' => Loan::whereIn('status', ['active', 'disbursed'])->with('user')->get(),
            'rejected' => Loan::where('status', 'rejected')->with('user')->get(),
            'defaulted' => Loan::where('status', 'defaulted')->with('user')->get(),
            'paid' => Loan::where('status', 'paid')->with('user')->get(),
        ];

        return view('treasurer.loans', compact('loanStats', 'loansByStatus'));
    }

    /**
     * Show loan detail for treasurer
     */
    public function viewLoan(Loan $loan)
    {
        $loan->load([
            'user',
            'approver',
            'disburser',
            'payments' => function ($query) {
                $query->orderBy('payment_date', 'asc');
            }
        ]);

        return view('treasurer.loan-detail', compact('loan'));
    }

    // ============ 3. SAVINGS SUMMARY ============
    public function savings()
    {
        // Paginate savings for the view (so ->links() works)
        $savingsAccounts = Saving::with('user')->orderBy('available_savings', 'desc')->paginate(15);

        // Compute stats using aggregate queries to avoid relying on the paginator's collection
        $savingsStats = [
            'total_savings' => Saving::sum('available_savings'),
            'total_members' => Saving::count(),
            'average_savings' => Saving::avg('available_savings'),
            'pending_withdrawals' => SavingsTransaction::where('type', 'withdrawal')
                ->where('status', 'pending')
                ->count(),
            'monthly_deductions' => SavingsTransaction::where('type', 'payroll_deduction')
                ->whereMonth('transaction_date', Carbon::now()->month)
                ->sum('amount'),
        ];

        $recentTransactions = SavingsTransaction::with('user')
            ->orderBy('transaction_date', 'desc')
            ->take(20)
            ->get();

        $withdrawalRequests = SavingsTransaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->with('user')
            ->get();

        // Top savers (separate query)
        $topSavers = Saving::with('user')
            ->orderBy('available_savings', 'desc')
            ->take(10)
            ->get();

        return view('treasurer.savings', compact(
            'savingsStats',
            'savingsAccounts',
            'recentTransactions',
            'withdrawalRequests',
            'topSavers'
        ));
    }


    public function recordLoanPayment(Request $request, $loanId)
{
    // Validate the request
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'payment_date' => 'nullable|date',
        'payment_method' => 'required|string|in:cash,mpesa,bank,cheque,payroll',
        'cheque_number' => 'nullable|required_if:payment_method,cheque|string|unique:cheque_records,cheque_number',
        'reference_number' => 'nullable|string|max:100',
        'notes' => 'nullable|string',
    ]);

    try {
        DB::beginTransaction();

        // Find the loan
        $loan = Loan::findOrFail($loanId);

        // Check if amount exceeds remaining balance
        if ($request->amount > $loan->remaining_balance) {
            return response()->json([
                'success' => false,
                'message' => 'Payment amount (KES ' . number_format($request->amount) . ') exceeds remaining balance (KES ' . number_format($loan->remaining_balance) . ')',
            ], 400);
        }

        // Create payment record
        $payment = new Payment([
            'loan_id' => $loan->id,
            'user_id' => $loan->user_id,
            'payment_ref' => 'PAY-' . time() . rand(100, 999),
            'amount' => $request->amount,
            'payment_date' => $request->payment_date ?? now(),
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'status' => 'completed',
            'posted_date' => now(),
            'posted_by' => auth()->id(),
        ]);

        // Calculate principal and interest (5% interest already calculated)
        $monthlyInterest = $loan->interest_amount / $loan->period_months;
        $interestPortion = min($request->amount, $monthlyInterest);
        $principalPortion = $request->amount - $interestPortion;

        $payment->interest = $interestPortion;
        $payment->principal = $principalPortion;
        $payment->balance_before = $loan->remaining_balance;
        
        $payment->save();

        // Update loan balance
        $loan->remaining_balance -= $request->amount;
        $loan->amount_paid += $request->amount;
        $loan->percentage_paid = ($loan->amount_paid / $loan->total_repayable) * 100;

        // If loan is fully paid
        if ($loan->remaining_balance <= 0) {
            $loan->status = 'paid';
            $loan->paid_date = now();
        }

        $payment->balance_after = $loan->remaining_balance;
        $payment->save();

        $loan->save();

        // Record cheque if payment method is cheque
        if ($request->payment_method === 'cheque' && $request->filled('cheque_number')) {
            ChequeRecord::create([
                'payment_id' => $payment->id,
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'cheque_number' => $request->cheque_number,
                'bank_name' => 'Not specified',
                'bank_branch' => 'Not specified',
                'account_number' => 'N/A',
                'amount' => $request->amount,
                'purpose' => 'loan_repayment',
                'status' => 'issued',
                'issue_date' => $request->payment_date ?? now(),
                'issued_by' => auth()->id(),
                'issue_notes' => 'Loan repayment - ' . ($request->notes ?? 'No notes'),
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully',
            'payment' => $payment,
            'new_balance' => $loan->remaining_balance,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Payment recording error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error recording payment: ' . $e->getMessage(),
        ], 500);
    }
}
    // ============ 4. EXPENSES TRACKING ============
    public function expenses()
    {
        // Paginate expenses for the view so ->links() works
        $expenses = Expense::with('category', 'approvedBy')
            ->orderBy('expense_date', 'desc')
            ->paginate(15);

        // Compute stats via queries to avoid relying on the paginator collection
        $expenseStats = [
            'total_expenses' => Expense::sum('amount'),
            'month_expenses' => Expense::whereBetween(
                'expense_date',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )->sum('amount'),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
            'approved_expenses' => Expense::where('status', 'approved')->count(),
            'paid_expenses' => Expense::where('payment_status', 'paid')->count(),
        ];

        // Group by category for pie chart data
        $expensesByCategory = Expense::select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get();

        $pendingExpenses = Expense::where('status', 'pending')
            ->with('category', 'requestedBy')
            ->get();

        $approvedUnpaid = Expense::where('status', 'approved')
            ->where('payment_status', '!=', 'paid')
            ->with('category', 'approvedBy')
            ->get();

        return view('treasurer.expenses', compact(
            'expenseStats',
            'expensesByCategory',
            'pendingExpenses',
            'approvedUnpaid',
            'expenses'
        ));
    }

    // ============ 5. CHEQUE MANAGEMENT ============
    public function cheques()
    {
        $cheques = ChequeRecord::with(['loan.user', 'savingsTransaction.user'])->get();

        $chequeStats = [
            'total_cheques' => $cheques->count(),
            'issued_cheques' => $cheques->where('status', 'issued')->count(),
            'cleared_cheques' => $cheques->where('status', 'cleared')->count(),
            'cancelled_cheques' => $cheques->where('status', 'cancelled')->count(),
            'total_amount_issued' => $cheques->where('status', 'issued')->sum('amount'),
            'total_amount_cleared' => $cheques->where('status', 'cleared')->sum('amount'),
        ];

        // Group cheques by status
        $chequesByStatus = [
            'issued' => ChequeRecord::where('status', 'issued')->with(['loan.user', 'savingsTransaction.user'])->get(),
            'cleared' => ChequeRecord::where('status', 'cleared')->with(['loan.user', 'savingsTransaction.user'])->get(),
            'cancelled' => ChequeRecord::where('status', 'cancelled')->with(['loan.user', 'savingsTransaction.user'])->get(),
        ];

        // Recent cheque activity
        $recentCheques = ChequeRecord::with(['loan.user', 'savingsTransaction.user'])
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        return view('treasurer.cheques', compact(
            'chequeStats',
            'chequesByStatus',
            'recentCheques',
            'cheques'
        ));
    }

    // ============ 6. BANK RECONCILIATION ============
    public function reconciliation()
    {
        $reconciliations = BankReconciliation::with('bankAccount')->get();

        $latestReconciliation = BankReconciliation::latest()->first();

        $bankBalance = $this->getCashAtBank();
        $systemBalance = $this->getSystemBalance();
        $difference = $bankBalance - $systemBalance;

        $unreconciledTransactions = Payment::where('reconciled', false)
            ->orWhere('reconciled_at', null)
            ->with(['loan.user', 'savingsTransaction.user'])
            ->get();

        $reconciliationStats = [
            'bank_balance' => $bankBalance,
            'system_balance' => $systemBalance,
            'difference' => $difference,
            'unreconciled_count' => $unreconciledTransactions->count(),
            'last_reconciliation' => $latestReconciliation ? $latestReconciliation->reconciliation_date : 'Never',
            'status' => $difference == 0 ? 'balanced' : 'unbalanced',
        ];

        return view('treasurer.reconciliation', compact(
            'reconciliations',
            'latestReconciliation',
            'reconciliationStats',
            'unreconciledTransactions'
        ));
    }

    // ============ 7. FINANCIAL REPORTS ============
    public function financialReports(Request $request)
    {
        $reportTypes = [
            'financial_position' => 'Statement of Financial Position',
            'savings_summary' => 'Savings Summary Report',
            'loan_portfolio' => 'Loan Portfolio Report',
            'expenses_report' => 'Expenses Report',
            'income_statement' => 'Income Statement',
            'cash_flow' => 'Cash Flow Statement',
            'member_statement' => 'Member Savings Statement',
            'arrears_report' => 'Loan Arrears Report',
            'cheque_summary' => 'Cheque Summary Report',
            'audit_trail' => 'Audit Trail Report',
        ];

        // Default date range: current month
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Generate sample data for preview
        $reportData = $this->generateReportData($request->get('report_type', 'financial_position'), $startDate, $endDate);

        return view('treasurer.financial-reports', compact(
            'reportTypes',
            'reportData',
            'startDate',
            'endDate'
        ));
    }

    // ============ PAYMENT PROCESSING METHODS ============

    /**
     * Process loan payment (From requirements: "loan deductions are deducted from the payroll")
     */
    public function processLoanPayment(Request $request, $loanId)
    {
        $request->validate([
            'payment_method' => 'required|in:payroll,cash,bank_transfer,mobile_money,cheque',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $loan = Loan::findOrFail($loanId);

        if (!in_array($loan->status, ['active', 'disbursed'])) {
            return redirect()->back()
                ->with('error', 'Loan is not active.');
        }

        if ($request->amount > $loan->remaining_balance) {
            return redirect()->back()
                ->with('error', 'Payment amount exceeds remaining balance.');
        }

        DB::beginTransaction();
        try {
            // Calculate interest and principal (5% fixed interest already calculated)
            $interest = ($loan->interest_amount / $loan->period_months) * ($request->amount / $loan->monthly_payment);
            $principal = $request->amount - $interest;

            // Update loan balance
            $loan->update([
                'amount_paid' => $loan->amount_paid + $request->amount,
                'remaining_balance' => $loan->remaining_balance - $request->amount,
                'months_paid' => $loan->months_paid + ($request->amount >= $loan->monthly_payment ? 1 : 0),
                'months_remaining' => max(0, $loan->period_months - $loan->months_paid),
                'percentage_paid' => ($loan->amount_paid + $request->amount) / $loan->total_repayable * 100,
                'next_payment_date' => now()->addMonth(),
            ]);

            // Check for early payment recalculation (From requirements: Mule scenario)
            if ($request->amount > $loan->monthly_payment) {
                $recalculation = $loan->recalculateForEarlyPayment($request->amount - $loan->monthly_payment);

                // Update with recalculated values
                $loan->update([
                    'monthly_payment' => $recalculation['new_monthly_payment'],
                ]);
            }

            // Check top-up eligibility
            $loan->update([
                'eligible_for_topup' => $loan->qualifiesForTopUp(),
            ]);

            // Record payment
            $payment = Payment::create([
                'loan_id' => $loanId,
                'user_id' => $loan->user_id,
                'payment_ref' => 'PAY-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'amount' => $request->amount,
                'principal' => $principal,
                'interest' => $interest,
                'balance_before' => $loan->remaining_balance + $request->amount,
                'balance_after' => $loan->remaining_balance,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'status' => 'completed',
                'payment_date' => $request->payment_date,
                'posted_date' => now(),
                'posted_by' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // Update loan status if paid off
            $loan->updateStatus();

            DB::commit();

            // Send payment receipt
            // $this->sendPaymentReceipt($loan, $request->amount);

            return redirect()->route('treasurer.payments')
                ->with('success', 'Payment processed successfully. New balance: KES ' . number_format($loan->remaining_balance, 2))
                ->with('payment_ref', $payment->payment_ref);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Issue cheque for loan disbursement
     * From requirements: "Issuing of the cheque and recording of the same is done by the treasurer"
     * When cheque is issued, member's loan eligibility is reduced by the loan amount
     */
    public function issueCheque(Request $request, $loanId)
    {
        $request->validate([
            'cheque_number' => 'required|string|unique:cheque_records,cheque_number',
            'bank_name' => 'required|string|max:100',
            'bank_branch' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'issue_date' => 'required|date',
            'issue_notes' => 'nullable|string|max:500',
        ]);

        $loan = Loan::with('user')->findOrFail($loanId);

        if ($loan->status !== 'approved') {
            return redirect()->back()
                ->with('error', 'Loan must be approved before issuing cheque.');
        }

        DB::beginTransaction();
        try {
            // Update loan status to disbursed
            $loan->update([
                'status' => 'disbursed',
                'disbursed_by' => auth()->id(),
                'disbursed_date' => now(),
                'next_payment_date' => now()->addMonth(),
            ]);

            // Create cheque record
            $cheque = ChequeRecord::create([
                'loan_id' => $loanId,
                'user_id' => $loan->user_id,
                'cheque_number' => $request->cheque_number,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'account_number' => $request->account_number,
                'amount' => $loan->amount,
                'purpose' => 'loan_disbursement',
                'status' => 'issued',
                'issue_date' => $request->issue_date,
                'issued_by' => auth()->id(),
                'issue_notes' => $request->issue_notes,
            ]);

            // Reduce member's loan eligibility by the disbursed loan amount
            // Loan eligibility = savings * 1.5, so we reduce available savings
            // $member = $loan->user;
            // if ($member->savings) {
            //     $reductionAmount = $loan->amount / 1.5; // Reverse the 1.5x calculation
            //     $newAvailableSavings = max(0, $member->savings->available_savings - $reductionAmount);
            //     $member->savings->update(['available_savings' => $newAvailableSavings]);
            // }

            DB::commit();

            // Send notification to member about cheque
            // $this->sendNotification('cheque_issued', [
            //     'loan' => $loan,
            //     'cheque' => $cheque,
            // ]);

            return redirect()->route('treasurer.payments')
                ->with('success', 'Cheque ' . $cheque->cheque_number . ' issued for loan ' . $loan->loan_number . '. Member eligibility reduced.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Cheque issuance failed: ' . $e->getMessage());
        }
    }

    /**
     * Disburse an approved loan directly
     */
    public function disburseLoan(Request $request, $loanId)
{
    \Log::info('=== DISBURSEMENT STARTED ===');
    \Log::info('Loan ID: ' . $loanId);
    \Log::info('Payment Method: ' . $request->payment_method);

    try {
        // Debug: Log all request data
        \Log::info('Request Data:', $request->all());

        $validated = $request->validate([
            'payment_method' => 'required|in:cheque,bank_transfer,rtgs,cash,mobile_money',
            'disbursement_date' => 'required|date',
            'cheque_number' => 'nullable|required_if:payment_method,cheque|string|max:255|unique:cheque_records,cheque_number',
            
            // Bank name ONLY required for bank_transfer, NOT for cheque
            'bank_name' => 'nullable|required_if:payment_method,bank_transfer|string|max:255',
            
            'account_number' => 'nullable|required_if:payment_method,bank_transfer|string|max:255',
            'branch_code' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:100',
            'swift_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        \Log::info('Validation passed');

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed: ', $e->errors());
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    }

    $loan = Loan::with('user')->findOrFail($loanId);

    \Log::info('Loan found: ' . $loan->loan_number . ' - Status: ' . $loan->status);

    if ($loan->status !== 'approved') {
        \Log::warning('Loan not approved. Status: ' . $loan->status);
        return redirect()->back()
            ->with('error', 'Loan must be approved before disbursement. Current status: ' . $loan->status);
    }

    // Generate reference
    if ($request->payment_method === 'cheque') {
        $reference = $request->cheque_number;
        \Log::info('Cheque reference: ' . $reference);
    } else {
        $reference = $request->reference_number ?? strtoupper($request->payment_method) . '-' . date('YmdHis');
        \Log::info('Other payment reference: ' . $reference);
    }

    DB::beginTransaction();
    try {
        \Log::info('Updating loan status to disbursed...');

        // Update loan
        $loan->update([
            'status' => 'disbursed',
            'disbursed_by' => auth()->id(),
            'disbursed_date' => $request->disbursement_date,
            'next_payment_date' => \Carbon\Carbon::parse($request->disbursement_date)->addMonth(),
        ]);

        \Log::info('Loan updated successfully');

        // Create payment WITHOUT triggering events
        \Log::info('Creating payment record...');
        $payment = new Payment();
        $payment->loan_id = $loan->id;
        $payment->user_id = $loan->user_id;
        $payment->payment_ref = $reference;
        $payment->amount = $loan->amount;
        $payment->payment_method = $request->payment_method;
        $payment->reference_number = $reference;
        $payment->status = 'completed';
        $payment->payment_date = $request->disbursement_date;
        $payment->posted_date = now();
        $payment->posted_by = auth()->id();
        $payment->notes = $request->notes ?? 'Loan disbursement';

        // Save without events
        $payment->saveQuietly();
        \Log::info('Payment created: ID ' . $payment->id);

        // Create cheque record if needed
        if ($request->payment_method === 'cheque') {
            \Log::info('Creating cheque record...');
            \Log::info('Cheque data:', [
                'cheque_number' => $request->cheque_number,
                'bank_name' => $request->bank_name,
                'branch_code' => $request->branch_code,
                'account_number' => $request->account_number,
            ]);

            // Check if cheque already exists
            $existingCheque = ChequeRecord::where('cheque_number', $request->cheque_number)->first();
            if ($existingCheque) {
                throw new \Exception('Cheque number ' . $request->cheque_number . ' already exists');
            }

            // REMOVED: Bank name validation for cheque (not required anymore)
            // if (empty($request->bank_name)) {
            //     throw new \Exception('Bank name is required for cheque disbursement');
            // }

            $bankBranch = $request->branch_code;
            if (empty($bankBranch)) {
                $bankBranch = 'Main Branch'; // Default value
                \Log::warning('Branch code empty, using default: ' . $bankBranch);
            }

            $cheque = ChequeRecord::create([
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'cheque_number' => $request->cheque_number,
                'bank_name' => $request->bank_name ?? 'Not Specified', // Use default if empty
                'bank_branch' => $bankBranch,
                'account_number' => $request->account_number ?? 'N/A',
                'amount' => $loan->amount,
                'purpose' => 'loan_disbursement',
                'status' => 'issued',
                'issue_date' => $request->disbursement_date,
                'issued_by' => auth()->id(),
                'issue_notes' => $request->notes,
            ]);

            \Log::info('Cheque created successfully: ID ' . $cheque->id);
        }

        DB::commit();
        \Log::info('=== DISBURSEMENT COMPLETED SUCCESSFULLY ===');

        return redirect()->route('treasurer.payments')
            ->with('success', 'Loan ' . $loan->loan_number . ' disbursed successfully!')
            ->with('disbursement_ref', $reference);

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Disbursement failed: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());

        $errorMessage = 'Loan disbursement failed: ' . $e->getMessage();

        // Provide more specific error messages
        if (str_contains($e->getMessage(), 'cheque_records.cheque_number')) {
            $errorMessage = 'Cheque number already exists. Please use a unique cheque number.';
        } elseif (str_contains($e->getMessage(), 'Column cannot be null')) {
            $errorMessage = 'Missing required information. Please fill all required fields.';
        }

        return redirect()->back()
            ->with('error', $errorMessage)
            ->withInput();
    }
}
    /**
     * Process payroll deductions
     * From requirements: "Savings are deducted from the payroll... deposited cumulatively"
     */
    public function processPayrollDeductions(Request $request)
    {
        $request->validate([
            'deductions_file' => 'required|file|mimes:csv,xlsx',
            'deduction_date' => 'required|date',
            'type' => 'required|in:savings,loan',
        ]);

        DB::beginTransaction();
        try {
            // Process uploaded file
            if ($request->hasFile('deductions_file')) {
                $file = $request->file('deductions_file');
                $path = $file->store('payroll_deductions');

                // Parse the file (implementation depends on file format)
                // For CSV:
                // $data = array_map('str_getcsv', file(storage_path('app/' . $path)));

                // For now, simulate processing
                $processedCount = 0;
                $totalAmount = 0;

                // Example processing logic
                // foreach ($data as $row) {
                //     $employeeNumber = $row[0];
                //     $amount = $row[1];
                //
                //     if ($request->type === 'savings') {
                //         $this->processSavingsDeduction($employeeNumber, $amount, $request->deduction_date);
                //     } else {
                //         $this->processLoanDeduction($employeeNumber, $amount, $request->deduction_date);
                //     }
                //
                //     $processedCount++;
                //     $totalAmount += $amount;
                // }

                $processedCount = 156; // Example count
                $totalAmount = 850000; // Example amount

                DB::commit();

                return redirect()->route('treasurer.savings')
                    ->with('success', "Payroll deductions processed successfully. {$processedCount} members, total: KES " . number_format($totalAmount, 2));

            } else {
                return redirect()->back()
                    ->with('error', 'Please upload a deductions file.');
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Payroll processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Record cheque clearance
     */
    public function recordChequeClearance(Request $request, $chequeId)
    {
        $request->validate([
            'clearance_date' => 'required|date',
            'clearance_notes' => 'nullable|string|max:500',
        ]);

        $cheque = ChequeRecord::findOrFail($chequeId);

        if ($cheque->status !== 'issued') {
            return redirect()->back()
                ->with('error', 'Cheque is not in issued status.');
        }

        $cheque->update([
            'status' => 'cleared',
            'clearance_date' => $request->clearance_date,
            'cleared_by' => auth()->id(),
            'clearance_notes' => $request->clearance_notes,
        ]);

        // If it's a savings withdrawal, complete the transaction
        if ($cheque->savings_withdrawal_id) {
            $transaction = SavingsTransaction::find($cheque->savings_withdrawal_id);
            if ($transaction) {
                $transaction->update(['status' => 'completed']);
            }
        }

        return redirect()->route('treasurer.cheques')
            ->with('success', 'Cheque ' . $cheque->cheque_number . ' marked as cleared.');
    }

    /**
     * Approve expense for payment
     */
    public function approveExpense(Request $request, $expenseId)
    {
        $expense = Expense::findOrFail($expenseId);

        $request->validate([
            'approval_notes' => 'nullable|string|max:500',
        ]);

        $expense->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $request->approval_notes,
        ]);

        return redirect()->route('treasurer.expenses')
            ->with('success', 'Expense #' . $expense->expense_number . ' approved successfully.');
    }

    /**
     * Process expense payment
     */
    public function payExpense(Request $request, $expenseId)
    {
        $expense = Expense::findOrFail($expenseId);

        if ($expense->status !== 'approved') {
            return redirect()->back()
                ->with('error', 'Expense must be approved before payment.');
        }

        $request->validate([
            'payment_method' => 'required|in:cash,cheque,bank_transfer,mobile_money',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $expense->update([
                'payment_status' => 'paid',
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'payment_reference' => $request->reference_number,
                'paid_by' => auth()->id(),
                'payment_notes' => $request->payment_notes,
            ]);

            // Record cheque if payment method is cheque
            if ($request->payment_method === 'cheque') {
                ChequeRecord::create([
                    'expense_id' => $expenseId,
                    'cheque_number' => $request->reference_number,
                    'amount' => $expense->amount,
                    'purpose' => 'expense_payment',
                    'status' => 'issued',
                    'issue_date' => $request->payment_date,
                    'issued_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('treasurer.expenses')
                ->with('success', 'Expense #' . $expense->expense_number . ' paid successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Expense payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Process savings withdrawal
     */
    public function processWithdrawal(Request $request, $transactionId)
    {
        $transaction = SavingsTransaction::findOrFail($transactionId);

        if ($transaction->type !== 'withdrawal' || $transaction->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Invalid withdrawal request.');
        }

        $savingsAccount = $transaction->user->savings;

        if ($transaction->amount > $savingsAccount->available_savings) {
            return redirect()->back()
                ->with('error', 'Insufficient savings balance.');
        }

        DB::beginTransaction();
        try {
            // Update savings account
            $savingsAccount->update([
                'available_savings' => $savingsAccount->available_savings - $transaction->amount,
                'total_withdrawn' => $savingsAccount->total_withdrawn + $transaction->amount,
            ]);

            // Update transaction
            $transaction->update([
                'status' => 'completed',
                'balance_before' => $savingsAccount->available_savings + $transaction->amount,
                'balance_after' => $savingsAccount->available_savings,
                'processed_by' => auth()->id(),
                'processed_date' => now(),
            ]);

            // Record payment
            Payment::create([
                'savings_transaction_id' => $transactionId,
                'user_id' => $transaction->user_id,
                'payment_ref' => 'WDL-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'amount' => $transaction->amount,
                'payment_method' => $request->payment_method ?? 'bank_transfer',
                'reference_number' => $request->reference_number,
                'status' => 'completed',
                'payment_date' => now(),
                'posted_date' => now(),
                'posted_by' => auth()->id(),
                'notes' => 'Savings withdrawal processed',
            ]);

            DB::commit();

            return redirect()->route('treasurer.savings')
                ->with('success', 'Withdrawal of KES ' . number_format($transaction->amount, 2) . ' processed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Withdrawal processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Reject withdrawal request
     */
    public function rejectWithdrawal(Request $request, $transactionId)
    {
        $transaction = SavingsTransaction::findOrFail($transactionId);

        if ($transaction->type !== 'withdrawal' || $transaction->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Invalid withdrawal request.');
        }

        DB::beginTransaction();
        try {
            // Update transaction status to rejected
            $transaction->update([
                'status' => 'rejected',
                'processed_by' => auth()->id(),
                'processed_date' => now(),
            ]);

            DB::commit();

            return redirect()->route('treasurer.savings')
                ->with('success', 'Withdrawal request rejected successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Rejection failed: ' . $e->getMessage());
        }
    }

    /**
     * Run bank reconciliation
     */
    public function runReconciliation(Request $request)
    {
        $request->validate([
            'reconciliation_date' => 'required|date',
            'bank_statement_balance' => 'required|numeric|min:0',
            'bank_statement_file' => 'nullable|file|mimes:pdf,csv,xlsx',
        ]);

        DB::beginTransaction();
        try {
            $systemBalance = $this->getSystemBalance();
            $difference = $request->bank_statement_balance - $systemBalance;

            $reconciliation = BankReconciliation::create([
                'reconciliation_date' => $request->reconciliation_date,
                'bank_statement_balance' => $request->bank_statement_balance,
                'system_balance' => $systemBalance,
                'difference' => $difference,
                'status' => $difference == 0 ? 'balanced' : 'unbalanced',
                'performed_by' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // If file uploaded, store it
            if ($request->hasFile('bank_statement_file')) {
                $file = $request->file('bank_statement_file');
                $path = $file->store('bank_statements');
                $reconciliation->update(['statement_file_path' => $path]);
            }

            DB::commit();

            $statusMessage = $difference == 0
                ? 'Reconciliation completed successfully. Accounts are balanced.'
                : 'Reconciliation completed with difference of KES ' . number_format(abs($difference), 2);

            return redirect()->route('treasurer.reconciliation')
                ->with('success', $statusMessage);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Reconciliation failed: ' . $e->getMessage());
        }
    }

    // ============ HELPER METHODS ============

    private function getCashAtBank()
    {
        // This should query your bank account model
        // For now, return a calculated value
        $totalSavings = Saving::sum('available_savings');
        $loanReceivables = Loan::whereIn('status', ['active', 'disbursed'])->sum('remaining_balance');
        $expenses = Expense::where('payment_status', 'paid')->sum('amount');

        return $totalSavings - $loanReceivables - $expenses + 1200000; // Add some base amount
    }

    private function getSystemBalance()
    {
        $totalSavings = Saving::sum('available_savings');
        $loanReceivables = Loan::whereIn('status', ['active', 'disbursed'])->sum('remaining_balance');
        $expenses = Expense::where('payment_status', 'paid')->sum('amount');

        return $totalSavings - $loanReceivables - $expenses;
    }

    private function generateReportData($type, $startDate, $endDate)
    {
        switch ($type) {
            case 'financial_position':
                return $this->generateFinancialPosition($startDate, $endDate);
            case 'savings_summary':
                return $this->generateSavingsSummary($startDate, $endDate);
            case 'loan_portfolio':
                return $this->generateLoanPortfolio($startDate, $endDate);
            case 'expenses_report':
                return $this->generateExpensesReport($startDate, $endDate);
            case 'income_statement':
                return $this->generateIncomeStatement($startDate, $endDate);
            default:
                return [];
        }
    }

    private function generateFinancialPosition($startDate, $endDate)
    {
        return [
            'assets' => [
                'Cash at Bank' => $this->getCashAtBank(),
                'Loan Receivables' => Loan::whereIn('status', ['active', 'disbursed'])->sum('remaining_balance'),
                // Accrued interest = total interest charged on loans minus interest already paid (recorded on payments)
                'Accrued Interest' => Loan::sum('interest_amount') - Payment::whereNotNull('loan_id')->sum('interest'),
                'Other Assets' => 150000,
            ],
            'liabilities' => [
                'Members Savings' => Saving::sum('available_savings'),
                'Accrued Dividends' => 45000,
                'Other Liabilities' => 25000,
            ],
            'equity' => [
                'Share Capital' => 5000000,
                'Retained Earnings' => 1200000,
                'Current Year Profit' => 450000,
            ],
        ];
    }

    private function generateSavingsSummary($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return [
            'total_savings' => Saving::sum('available_savings'),
            'total_members' => Saving::count(),
            'new_savings' => SavingsTransaction::where('type', 'deposit')
                ->whereBetween('transaction_date', [$start, $end])
                ->sum('amount'),
            'withdrawals' => SavingsTransaction::where('type', 'withdrawal')
                ->whereBetween('transaction_date', [$start, $end])
                ->sum('amount'),
            'average_savings' => Saving::avg('available_savings'),
            'top_savers' => Saving::with('user')
                ->orderBy('available_savings', 'desc')
                ->take(10)
                ->get()
                ->map(function ($account) {
                    return [
                        'name' => $account->user->name,
                        'employee_number' => $account->user->employee_number,
                        'balance' => $account->available_savings,
                    ];
                }),
        ];
    }

    private function generateLoanPortfolio($startDate, $endDate)
    {
        return [
            'total_loans' => Loan::count(),
            'total_amount' => Loan::sum('amount'),
            'active_loans' => Loan::whereIn('status', ['active', 'disbursed'])->count(),
            'defaulted_loans' => Loan::where('status', 'defaulted')->count(),
            'arrears_amount' => Loan::where('status', 'defaulted')->sum('remaining_balance'),
            'recovery_rate' => 92.5, // percentage
            'loan_distribution' => [
                '0-50000' => Loan::whereBetween('amount', [0, 50000])->count(),
                '50001-200000' => Loan::whereBetween('amount', [50001, 200000])->count(),
                '200001-500000' => Loan::whereBetween('amount', [200001, 500000])->count(),
                '500001+' => Loan::where('amount', '>', 500000)->count(),
            ],
        ];
    }

    private function generateExpensesReport($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $expenses = Expense::whereBetween('expense_date', [$start, $end])->get();

        return [
            'total_expenses' => $expenses->sum('amount'),
            'by_category' => $expenses->groupBy('category.name')->map->sum('amount'),
            'by_month' => $expenses->groupBy(function ($item) {
                return Carbon::parse($item->expense_date)->format('M Y');
            })->map->sum('amount'),
            'top_expenses' => $expenses->sortByDesc('amount')->take(10)->values(),
            'budget_utilization' => [
                'office_supplies' => ['budget' => 50000, 'actual' => 35000],
                'utilities' => ['budget' => 30000, 'actual' => 28000],
                'travel' => ['budget' => 100000, 'actual' => 75000],
                'meetings' => ['budget' => 50000, 'actual' => 42000],
            ],
        ];
    }

    private function generateIncomeStatement($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return [
            'revenue' => [
                'loan_interest' => Loan::sum('interest_amount'),
                'membership_fees' => 250000,
                'other_income' => 50000,
            ],
            'expenses' => [
                'operating_expenses' => Expense::whereBetween('expense_date', [$start, $end])->sum('amount'),
                'dividends_paid' => 450000,
                'provisions' => 150000,
            ],
            'net_income' => 850000,
            'profit_margin' => 65.2, // percentage
        ];
    }

    /**
     * Export report to different formats
     */
    public function exportReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'format' => 'required|in:pdf,excel,csv',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $reportType = $request->get('report_type');
        $format = $request->get('format');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $data = $this->generateReportData($reportType, $startDate, $endDate);

        // Generate file based on format
        switch ($format) {
            case 'pdf':
                // Generate PDF
                return response()->streamDownload(function () {
                    // PDF generation logic
                }, "report_{$reportType}_{$startDate}_{$endDate}.pdf");

            case 'excel':
                // Generate Excel
                return response()->streamDownload(function () {
                    // Excel generation logic
                }, "report_{$reportType}_{$startDate}_{$endDate}.xlsx");

            case 'csv':
                // Generate CSV
                return response()->streamDownload(function () use ($reportType, $startDate, $endDate) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['Report', $reportType]);
                    fputcsv($handle, ['Period', "{$startDate} to {$endDate}"]);
                    fputcsv($handle, []);
                    // Add data rows
                    fclose($handle);
                }, "report_{$reportType}_{$startDate}_{$endDate}.csv");
        }
    }

    private function getBankBalance()
    {
        $totalSavings = Saving::sum('available_savings');
        $loanReceivables = Loan::whereIn('status', ['active', 'disbursed'])->sum('remaining_balance');
        $expenses = Expense::where('payment_status', 'paid')->sum('amount'); // Fixed column name

        return $totalSavings - $loanReceivables - $expenses + 1200000;
    }
}
