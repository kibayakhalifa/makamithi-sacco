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
}
