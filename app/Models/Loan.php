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
        'loan_type', // Now: 'first_loan' or 'second_loan'
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
        // NEW FIELDS:
        'parent_loan_id', // For second loans, points to the first loan
        'phone',
        'profile_photo_path',
        'national_id_image'
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

    // NEW RELATIONSHIPS FOR SECOND LOAN SUPPORT
    public function parentLoan()
    {
        return $this->belongsTo(Loan::class, 'parent_loan_id');
    }

    public function secondLoan()
    {
        return $this->hasOne(Loan::class, 'parent_loan_id')->where('loan_type', 'second_loan');
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

    // NEW SCOPES FOR LOAN TYPES
    public function scopeFirstLoans($query)
    {
        return $query->where('loan_type', 'first_loan');
    }

    public function scopeSecondLoans($query)
    {
        return $query->where('loan_type', 'second_loan');
    }

    public function scopeWithParentLoan($query)
    {
        return $query->whereNotNull('parent_loan_id');
    }

    public function scopeWithoutParentLoan($query)
    {
        return $query->whereNull('parent_loan_id');
    }

    public function scopeEligibleForSecondLoan($query)
    {
        return $query->where('percentage_paid', '>=', 50)
                    ->where('loan_type', 'first_loan')
                    ->whereIn('status', ['active', 'disbursed']);
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
     * Check if this loan qualifies for second loan (50% paid)
     */
    public function qualifiesForSecondLoan()
    {
        return $this->loan_type === 'first_loan' && 
               $this->percentage_paid >= 50 &&
               in_array($this->status, ['active', 'disbursed', 'approved']);
    }

    /**
     * Check if user has an active second loan
     */
    public function hasActiveSecondLoan()
    {
        return $this->secondLoan()->whereIn('status', ['active', 'disbursed', 'approved'])->exists();
    }

    /**
     * Calculate available amount for second loan
     */
    public function availableForSecondLoan($userEligibility)
    {
        if (!$this->qualifiesForSecondLoan()) {
            return 0;
        }

        $totalActiveLoans = $this->user->loans()
            ->whereIn('status', ['active', 'disbursed', 'approved'])
            ->whereIn('loan_type', ['first_loan', 'second_loan'])
            ->sum('remaining_balance');

        $available = max(0, $userEligibility - $totalActiveLoans);
        return max(5000, $available); // Minimum 5,000
    }

    /**
     * Check if this is a first loan
     */
    public function isFirstLoan()
    {
        return $this->loan_type === 'first_loan';
    }

    /**
     * Check if this is a second loan
     */
    public function isSecondLoan()
    {
        return $this->loan_type === 'second_loan';
    }

    /**
     * Get the associated first loan (for second loans)
     */
    public function getFirstLoanAttribute()
    {
        if ($this->isSecondLoan() && $this->parentLoan) {
            return $this->parentLoan;
        }
        return null;
    }

    /**
     * Calculate early payment recalculation
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

    /**
     * Update loan progress after payment
     */
    public function updateProgress()
    {
        $this->percentage_paid = $this->total_repayable > 0 
            ? ($this->amount_paid / $this->total_repayable) * 100 
            : 0;
        
        // Update months paid based on payments
        $this->months_paid = ceil($this->amount_paid / max($this->monthly_payment, 1));
        $this->months_remaining = max(0, $this->period_months - $this->months_paid);
        
        $this->save();
    }

    /**
     * Generate payment schedule for this loan
     */
    public function generatePaymentSchedule()
    {
        $schedule = [];
        $startDate = $this->disbursed_date ?? $this->approved_date ?? $this->applied_date;
        
        for ($i = 1; $i <= $this->period_months; $i++) {
            $dueDate = $startDate->copy()->addMonths($i);
            
            // Check if payment exists for this installment
            $payment = $this->payments()->where('installment_number', $i)->first();
            
            $schedule[] = [
                'installment' => $i,
                'due_date' => $dueDate,
                'amount_due' => $this->monthly_payment,
                'status' => $payment ? 'paid' : 'pending',
                'paid_date' => $payment ? $payment->payment_date : null,
                'amount_paid' => $payment ? $payment->amount : 0,
                'is_overdue' => !$payment && $dueDate < now(),
                'is_next' => false, // Will be set dynamically
            ];
        }
        
        return $schedule;
    }

    /**
     * Get next payment due
     */
    public function getNextPaymentAttribute()
    {
        $schedule = $this->generatePaymentSchedule();
        
        foreach ($schedule as $key => $installment) {
            if ($installment['status'] === 'pending') {
                // Mark this as the next payment
                $schedule[$key]['is_next'] = true;
                return $schedule[$key];
            }
        }
        
        return null;
    }

    /**
     * Check if loan is fully paid
     */
    public function getIsFullyPaidAttribute()
    {
        return $this->remaining_balance <= 0 || $this->percentage_paid >= 100;
    }

    /**
     * Get formatted loan type name
     */
    public function getLoanTypeNameAttribute()
    {
        $types = [
            'first_loan' => 'First Loan',
            'second_loan' => 'Second Loan',
        ];
        
        return $types[$this->loan_type] ?? ucfirst(str_replace('_', ' ', $this->loan_type));
    }
}