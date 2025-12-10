<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsController extends Controller
{
    //
    /**
     * Handle member top-up (voluntary savings)
     */
    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            // Find or create the saving account for the user
            $saving = Saving::firstOrCreate(
                ['user_id' => $userId],
                [
                    'payroll_savings' => 0,
                    'voluntary_savings' => 0,
                    'interest_earned' => 0,
                    'total_savings' => 0,
                    'withdrawn_savings' => 0,
                    'available_savings' => 0,
                    'loan_eligibility' => 0,
                    'last_updated' => now(),
                ]
            );

            $balanceBefore = $saving->available_savings;
            $amount = $request->amount;

            // Update saving totals
            $saving->voluntary_savings = ($saving->voluntary_savings ?? 0) + $amount;
            $saving->total_savings = ($saving->total_savings ?? 0) + $amount;
            $saving->available_savings = ($saving->available_savings ?? 0) + $amount;
            $saving->last_updated = now();
            $saving->save();

            // Record transaction
            SavingsTransaction::recordTransaction([
                'user_id' => $userId,
                'saving_id' => $saving->id,
                'transaction_type' => 'deposit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $saving->available_savings,
                'description' => $request->description ?? 'Voluntary top-up',
                'transaction_date' => now(),
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Savings topped up successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to top up savings: ' . $e->getMessage());
        }
    }
}
