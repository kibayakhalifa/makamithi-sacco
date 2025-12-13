<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_number',
        'loan_type',
        'amount',
        'interest_rate',
        'interest_amount',
        'total_repayable',
        'period_months',
        'monthly_payment',
        'amount_paid',
        'remaining_balance',
        'months_paid',
        'months_remaining',
        'percentage_paid',
        'eligible_for_topup',
        'purpose',
        'application_type',
        'assisted_by',
        'status',
        'approved_by',
        'disbursed_by',
        'applied_date',
        'approved_date',
        'disbursed_date',
        'expected_completion_date',
        'actual_completion_date',
        'next_payment_date',
        'rejection_reason',
        'support_document',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_repayable' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'percentage_paid' => 'decimal:2',
        'eligible_for_topup' => 'boolean',
        'applied_date' => 'date',
        'approved_date' => 'date',
        'disbursed_date' => 'date',
        'expected_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'next_payment_date' => 'date',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assistant()
    {
        return $this->belongsTo(User::class, 'assisted_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function disburser()
    {
        return $this->belongsTo(User::class, 'disbursed_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'loan_id');
    }

    public function chequeRecord()
    {
        return $this->hasOne(ChequeRecord::class);
    }

    // ========== SCOPES ==========
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'disbursed']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDefaulted($query)
    {
        return $query->where('status', 'defaulted');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('loan_type', $type);
    }

    // ========== BUSINESS LOGIC METHODS ==========
    
    /**
     * Calculate loan details based on amount and period
     */
    public static function calculateLoanDetails($amount, $periodMonths)
    {
        $interestRate = 5.00; // Fixed 5%
        $interestAmount = $amount * ($interestRate / 100);
        $totalRepayable = $amount + $interestAmount;
        $monthlyPayment = $periodMonths > 0 ? $totalRepayable / $periodMonths : 0;
        
        return [
            'interest_rate' => $interestRate,
            'interest_amount' => $interestAmount,
            'total_repayable' => $totalRepayable,
            'monthly_payment' => $monthlyPayment,
        ];
    }

    /**
     * Check if this loan qualifies for top-up (50% paid)
     */
    public function qualifiesForTopUp()
    {
        return $this->percentage_paid >= 50;
    }

    /**
     * Calculate early payment recalculation
     * Example from requirements: If Mule pays 50k early
     */
    public function recalculateForEarlyPayment($earlyPaymentAmount)
    {
        $newBalance = $this->remaining_balance - $earlyPaymentAmount;
        $newMonthlyPayment = $this->months_remaining > 0 ? $newBalance / $this->months_remaining : 0;
        
        return [
            'new_balance' => $newBalance,
            'new_monthly_payment' => $newMonthlyPayment,
            'months_affected' => $this->months_remaining,
        ];
    }

    /**
     * Generate next loan number
     */
    public static function generateLoanNumber()
    {
        $date = date('Ymd');
        $lastLoan = self::where('loan_number', 'like', "LN-{$date}-%")
                        ->orderBy('loan_number', 'desc')
                        ->first();
        
        $sequence = $lastLoan ? (int)substr($lastLoan->loan_number, -4) + 1 : 1;
        
        return "LN-{$date}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Update loan status based on payments
     */
    public function updateStatus()
    {
        if ($this->remaining_balance <= 0) {
            $this->status = 'completed';
            $this->actual_completion_date = now();
        } elseif ($this->next_payment_date && now()->gt($this->next_payment_date->addDays(30))) {
            $this->status = 'defaulted';
        }
        
        $this->save();
    }
}