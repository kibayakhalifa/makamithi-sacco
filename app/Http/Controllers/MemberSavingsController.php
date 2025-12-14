<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\SavingsTransaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberSavingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member');
    }

    /**
     * Display savings page
     */
    public function index()
    {
        $user = Auth::user();
        $savings = $user->savings;
        
        if (!$savings) {
            return redirect()->route('member.dashboard')
                ->with('error', 'No savings account found. Please contact the secretary to set up your savings account.');
        }
        
        // Get transaction history
        $transactions = $savings->transactions()
            ->latest()
            ->paginate(15);
        
        // Calculate statistics
        $stats = [
            'monthly_contribution' => $user->monthly_savings ?? 0,
            'year_to_date' => $savings->transactions()
                ->where('type', 'voluntary_deposit')
                ->whereYear('transaction_date', date('Y'))
                ->sum('amount'),
            'interest_earned' => $savings->interest_earned,
            'loan_qualification' => $savings->loan_eligibility,
        ];
        
        // Get growth data for chart
        $growthData = $this->getSavingsGrowthData($savings);
        
        return view('member.savings.index', compact(
            'savings', 'transactions', 'stats', 'growthData'
        ));
    }

    /**
     * Process savings top-up
     */
    public function topup(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:100', 'max:1000000'],
            'payment_method' => ['required', 'string', 'in:mpesa,bank_transfer,cheque,cash'],
            'reference' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);
        
        $user = Auth::user();
        $savings = $user->savings;
        
        if (!$savings) {
            return redirect()->back()->with('error', 'No savings account found. Please contact the secretary.');
        }
        
        DB::beginTransaction();
        
        try {
            // Process top-up
            $savings->addVoluntarySavings($request->amount);
            
            // Record transaction
            $transaction = SavingsTransaction::create([
                'user_id' => $user->id,
                'transaction_ref' => 'TOPUP-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-' . time(),
                'type' => 'voluntary_deposit',
                'amount' => $request->amount,
                'balance_before' => $savings->available_savings - $request->amount,
                'balance_after' => $savings->available_savings,
                'reference_number' => $request->reference,
                'description' => 'Voluntary savings top-up via ' . ucfirst($request->payment_method),
                'payment_method' => $request->payment_method,
                'transaction_date' => now()->toDateString(),
                'status' => 'completed',
                'posted_by' => $user->id,
            ]);
            
            DB::commit();
            
            return redirect()->route('member.savings.index')
                ->with('success', 'Savings top-up successful! KES ' . number_format($request->amount, 2) . ' added to your account.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to process top-up: ' . $e->getMessage());
        }
    }

    /**
     * Submit withdrawal request
     */
    public function withdrawalRequest(Request $request)
    {
        // Debug: Log all incoming data
        \Log::info('=== WITHDRAWAL REQUEST DEBUG ===');
        \Log::info('User ID: ' . auth()->id());
        \Log::info('All request data:', $request->all());
        
        $user = Auth::user();
        
        // Validate with conditional rules
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:1', 'max:1000000'],
            'withdrawal_reason' => ['required', 'string', 'in:resignation,retirement,medical_emergency,other'],
            'payment_method' => ['required', 'string', 'in:bank_transfer,mpesa,cheque'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'bank_branch' => ['nullable', 'string', 'max:100'],
            'mpesa_number' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'mpesa_number.required_if' => 'M-Pesa number is required when selecting M-Pesa as payment method.',
            'bank_account_name.required_if' => 'Bank account name is required for bank transfer.',
            'bank_name.required_if' => 'Bank name is required for bank transfer.',
            'bank_account_number.required_if' => 'Bank account number is required for bank transfer.',
        ]);
        
        // Add conditional required rules
        $validator->sometimes('mpesa_number', 'required', function ($input) {
            return $input->payment_method === 'mpesa';
        });
        
        $validator->sometimes(['bank_account_name', 'bank_name', 'bank_account_number'], 'required', function ($input) {
            return $input->payment_method === 'bank_transfer';
        });
        
        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $savings = $user->savings;
        
        if (!$savings) {
            return redirect()->back()->with('error', 'No savings account found.');
        }
        
        // Check if requested amount is withdrawable (apply KES 2,000 retention)
        $withdrawableAmount = max(0, $savings->available_savings - 2000);
        
        if ($request->amount > $withdrawableAmount) {
            return redirect()->back()->with('error', 
                'Requested amount exceeds withdrawable balance. Maximum withdrawable: KES ' . 
                number_format($withdrawableAmount, 2) . ' (KES 2,000 retention required)'
            )->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Create withdrawal request
            $withdrawal = WithdrawalRequest::create([
                'user_id' => $user->id,
                'saving_id' => $savings->id,
                'amount' => $request->amount,
                'available_savings' => $savings->available_savings,
                'withdrawal_reason' => $request->withdrawal_reason,
                'payment_method' => $request->payment_method,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_branch' => $request->bank_branch,
                'mpesa_number' => $request->mpesa_number,
                'status' => 'pending',
                'user_notes' => $request->notes,
            ]);
            
            // Record pending transaction
            $transaction = SavingsTransaction::create([
                'user_id' => $user->id,
                'saving_id' => $savings->id,
                'withdrawal_request_id' => $withdrawal->id,
                'transaction_ref' => 'WDR-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . '-' . time(),
                'type' => 'withdrawal',
                'amount' => $request->amount, // positive amount for withdrawal request
                'balance_before' => $savings->available_savings,
                'balance_after' => $savings->available_savings - $request->amount,
                'description' => 'Withdrawal request - ' . ucfirst(str_replace('_', ' ', $request->withdrawal_reason)),
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'transaction_date' => now(),
                'notes' => $request->notes,
            ]);
            
            DB::commit();
            
            \Log::info('Withdrawal request created successfully. ID: ' . $withdrawal->id);
            
            return redirect()->route('member.savings.index')
                ->with('success', 'Withdrawal request submitted successfully! It will be processed within 3-5 working days.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Withdrawal request failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to submit withdrawal request: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get savings growth data for chart
     */
    private function getSavingsGrowthData($savings)
    {
        $data = [];
        
        // Get last 12 months of deposit data
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth()->toDateString();
            $monthEnd = $month->copy()->endOfMonth()->toDateString();
            
            $monthlyDeposits = $savings->transactions()
                ->whereIn('type', ['payroll_deduction', 'voluntary_deposit', 'interest_credit'])
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');
            
            $data[] = [
                'month' => $month->format('M Y'),
                'deposits' => $monthlyDeposits,
                'cumulative' => $savings->transactions()
                    ->whereIn('type', ['payroll_deduction', 'voluntary_deposit', 'interest_credit'])
                    ->where('transaction_date', '<=', $monthEnd)
                    ->sum('amount'),
            ];
        }
        
        return $data;
    }
}