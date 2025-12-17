<?php

namespace App\Services;

use App\Models\User;

class LoanEligibilityService
{
    public static function checkEligibility(User $user, $loanType = 'first')
    {
        $eligibility = $user->loan_eligibility;
        
        if ($loanType === 'first') {
            return self::checkFirstLoanEligibility($user, $eligibility);
        } else {
            return self::checkSecondLoanEligibility($user, $eligibility);
        }
    }
    
    private static function checkFirstLoanEligibility(User $user, $eligibility)
    {
        if ($user->hasActiveFirstLoan()) {
            return [
                'eligible' => false,
                'message' => 'You already have an active first loan.',
                'max_amount' => 0,
            ];
        }
        
        $maxAmount = min($eligibility, 1000000);
        
        return [
            'eligible' => true,
            'message' => 'Eligible for first loan',
            'max_amount' => $maxAmount,
        ];
    }
    
    private static function checkSecondLoanEligibility(User $user, $eligibility)
    {
        if (!$user->hasActiveFirstLoan()) {
            return [
                'eligible' => false,
                'message' => 'You need an active first loan to apply for a second loan.',
                'max_amount' => 0,
            ];
        }
        
        if ($user->hasActiveSecondLoan()) {
            return [
                'eligible' => false,
                'message' => 'You already have an active second loan.',
                'max_amount' => 0,
            ];
        }
        
        $firstLoan = $user->activeFirstLoan()->first();
        
        if ($firstLoan->percentage_paid < 50) {
            return [
                'eligible' => false,
                'message' => 'You need to repay 50% of your first loan. Currently at ' . 
                            number_format($firstLoan->percentage_paid, 1) . '% repaid.',
                'max_amount' => 0,
            ];
        }
        
        $totalActiveLoans = $user->activeLoans()->sum('remaining_balance');
        $secondLoanEligibility = max(0, $eligibility - $totalActiveLoans);
        $maxAmount = min($secondLoanEligibility, 1000000);
        
        if ($maxAmount < 5000) {
            return [
                'eligible' => false,
                'message' => 'You have reached your maximum loan limit.',
                'max_amount' => 0,
            ];
        }
        
        return [
            'eligible' => true,
            'message' => 'Eligible for second loan',
            'max_amount' => $maxAmount,
        ];
    }
}