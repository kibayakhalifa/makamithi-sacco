<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payroll_savings',
        'voluntary_savings',
        'interest_earned',
        'total_savings',
        'withdrawn_savings',
        'available_savings',
        'loan_eligibility',
        'last_updated',
    ];

    protected $casts = [
        'payroll_savings' => 'decimal:2',
        'voluntary_savings' => 'decimal:2',
        'interest_earned' => 'decimal:2',
        'total_savings' => 'decimal:2',
        'withdrawn_savings' => 'decimal:2',
        'available_savings' => 'decimal:2',
        'loan_eligibility' => 'decimal:2',
        'last_updated' => 'date',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(SavingsTransaction::class, 'user_id', 'user_id');
    }

    // ========== BUSINESS LOGIC ==========
    
    /**
     * Calculate loan eligibility (1.5× rule)
     */
    public function calculateLoanEligibility()
    {
        $this->loan_eligibility = $this->available_savings * 1.5;
        return $this;
    }

    /**
     * Add payroll savings
     */
    public function addPayrollSavings($amount)
    {
        $this->payroll_savings += $amount;
        $this->updateTotals();
        return $this;
    }

    /**
     * Add voluntary savings (top-up)
     */
    public function addVoluntarySavings($amount)
    {
        $this->voluntary_savings += $amount;
        $this->updateTotals();
        return $this;
    }

    /**
     * Process savings withdrawal with KES 2,000 retention
     */
    public function processWithdrawal($requestedAmount)
    {
        // Check if member can withdraw (employment ended)
        if (!$this->user->canWithdrawSavings()) {
            throw new \Exception('Member not eligible for savings withdrawal');
        }
        
        // Apply KES 2,000 retention
        $withdrawable = max(0, $this->available_savings - 2000);
        
        if ($requestedAmount > $withdrawable) {
            throw new \Exception('Insufficient withdrawable balance');
        }
        
        $this->withdrawn_savings += $requestedAmount;
        $this->updateTotals();
        
        return [
            'withdrawn' => $requestedAmount,
            'retained' => 2000,
            'new_balance' => $this->available_savings,
        ];
    }

    /**
     * Update all calculated totals
     */
    private function updateTotals()
    {
        $this->total_savings = $this->payroll_savings + $this->voluntary_savings + $this->interest_earned;
        $this->available_savings = $this->total_savings - $this->withdrawn_savings;
        $this->calculateLoanEligibility();
        $this->last_updated = now();
        $this->save();
    }

    /**
     * Create initial savings record for new member
     */
    public static function createForNewMember($user, $monthlySavingsAmount)
    {
        return self::create([
            'user_id' => $user->id,
            'payroll_savings' => $monthlySavingsAmount,
            'voluntary_savings' => 0,
            'interest_earned' => 0,
            'total_savings' => $monthlySavingsAmount,
            'withdrawn_savings' => 0,
            'available_savings' => $monthlySavingsAmount,
            'loan_eligibility' => $monthlySavingsAmount * 1.5,
            'last_updated' => now(),
        ]);
    }
}