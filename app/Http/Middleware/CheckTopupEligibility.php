<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTopupEligibility
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get current user
        $user = $request->user();
        
        // In real app, check database
        // For now, use session or mock data
        $hasActiveLoan = true; // Would be: $user->loans()->where('status', 'active')->exists()
        $repaymentPercentage = 28.3; // Would be calculated from database
        
        if (!$hasActiveLoan) {
            return redirect()->route('loans.apply')
                ->with('error', 'You need an active loan to access top-up facility.');
        }
        
        if ($repaymentPercentage < 50) {
            return redirect()->route('loans.apply')
                ->with('warning', 'You need to repay 50% of your current loan to qualify for top-up.');
        }
        
        return $next($request);
    }
}