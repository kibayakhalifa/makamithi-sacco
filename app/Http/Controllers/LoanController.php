<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    //
    /**
     * Handle member loan application
     */
    public function apply(Request $request)
    {
        $request->validate([
            'loan_type' => 'required|string|max:50',
            'amount' => 'required|numeric|min:1',
            'period_months' => 'required|integer|min:1',
            'purpose' => 'nullable|string|max:500',
        ]);

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $loanNumber = 'LN-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $interestRate = 5.0; // default interest rate (percent)
            $interestAmount = ($request->amount * $interestRate) / 100;
            $totalRepayable = $request->amount + $interestAmount;
            $monthlyPayment = $totalRepayable / max(1, $request->period_months);

            $loan = Loan::create([
                'user_id' => $userId,
                'loan_number' => $loanNumber,
                'loan_type' => $request->loan_type,
                'amount' => $request->amount,
                'interest_rate' => $interestRate,
                'interest_amount' => $interestAmount,
                'total_repayable' => $totalRepayable,
                'period_months' => $request->period_months,
                'monthly_payment' => $monthlyPayment,
                'amount_paid' => 0,
                'remaining_balance' => $totalRepayable,
                'months_paid' => 0,
                'months_remaining' => $request->period_months,
                'percentage_paid' => 0,
                'purpose' => $request->purpose,
                'status' => 'pending',
                'applied_date' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Loan application submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit loan application: ' . $e->getMessage());
        }
    }
    public function show(Loan $loan)
    {
        // Check authorization based on role
        $user = auth()->user();
        
        if ($user->hasRole('member')) {
            // Member can only view their own loans
            if ($loan->user_id !== $user->id) {
                abort(403, 'You can only view your own loans.');
            }
        }
        // Treasurer, Chairman, Secretary can view any loan
        
        // Load data
        $loan->load(['user', 'payments' => function($q) {
            $q->where('status', 'completed')->orderBy('payment_date');
        }, 'approver', 'disburser']);
        
        // Simple calculations
        $remainingBalance = $loan->remaining_balance;
        $percentagePaid = $loan->percentage_paid;
        $monthsPaid = $loan->months_paid;
        $remainingMonths = max(1, $loan->period_months - $monthsPaid);
        $futureMonthly = ceil($remainingBalance / $remainingMonths);
        
        // Determine which view to show based on role
        $role = $user->role;
        
        return view("loans.show-{$role}", compact(
            'loan',
            'remainingBalance',
            'percentagePaid',
            'monthsPaid',
            'futureMonthly'
        ));
    }
    
    /**
     * Print schedule for any role
     */
    public function printSchedule(Loan $loan)
    {
        // Check authorization
        $user = auth()->user();
        
        if ($user->hasRole('member') && $loan->user_id !== $user->id) {
            abort(403, 'You can only print your own loan schedules.');
        }
        
        $loan->load('user');
        
        return view('loans.print-schedule', compact('loan'));
    }
}
