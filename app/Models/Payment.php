<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_ref',
        'loan_id',
        'savings_transaction_id',
        'expense_id',
        'user_id',
        'type',
        'amount',
        'principal',
        'interest',
        'balance_before',
        'balance_after',
        'payment_method',
        'reference_number',
        'status',
        'payment_date',
        'posted_date',
        'posted_by',
        'processed_by',
        'processed_date',
        'reconciled',
        'reconciled_at',
        'reconciliation_id',
        'notes',
        // NEW FIELDS FOR LOAN SCHEDULE FUNCTIONALITY
        'installment_number',
        'is_early_repayment',
        'remarks',
        'month_covered',
        'penalty_amount',
        'penalty_waived',
        'waiver_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'principal' => 'decimal:2',
        'interest' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'payment_date' => 'date',
        'posted_date' => 'datetime',
        'reconciled' => 'boolean',
        'reconciled_at' => 'datetime',
        'penalty_amount' => 'decimal:2',
        'penalty_waived' => 'boolean',
        'is_early_repayment' => 'boolean',
        // NEW CASTS
        'installment_number' => 'integer',
        'month_covered' => 'date',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function savingsTransaction()
    {
        return $this->belongsTo(SavingsTransaction::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function reconciliation()
    {
        return $this->belongsTo(BankReconciliation::class);
    }

    // NEW: Loan payment specific relationship
    public function loanSchedule()
    {
        return $this->belongsTo(LoanSchedule::class, 'installment_number', 'installment_number')
            ->where('loan_id', $this->loan_id);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeReconciled($query)
    {
        return $query->where('reconciled', true);
    }

    public function scopeUnreconciled($query)
    {
        return $query->where('reconciled', false)
            ->orWhereNull('reconciled_at');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeLoanPayments($query)
    {
        return $query->whereNotNull('loan_id');
    }

    public function scopeSavingsWithdrawals($query)
    {
        return $query->whereNotNull('savings_transaction_id');
    }

    public function scopeExpensePayments($query)
    {
        return $query->whereNotNull('expense_id');
    }

    // NEW SCOPES FOR LOAN PAYMENTS
    public function scopeEarlyRepayments($query)
    {
        return $query->where('is_early_repayment', true);
    }

    public function scopeRegularRepayments($query)
    {
        return $query->where('is_early_repayment', false)
            ->orWhereNull('is_early_repayment');
    }

    public function scopeByInstallment($query, $installmentNumber)
    {
        return $query->where('installment_number', $installmentNumber);
    }

    public function scopeForLoan($query, $loanId)
    {
        return $query->where('loan_id', $loanId);
    }

    public function scopeWithPenalty($query)
    {
        return $query->where('penalty_amount', '>', 0);
    }

    public function scopeWithoutPenalty($query)
    {
        return $query->where('penalty_amount', 0)
            ->orWhereNull('penalty_amount');
    }

    // Methods
    public function markAsReconciled($reconciliationId = null)
    {
        $this->update([
            'reconciled' => true,
            'reconciled_at' => now(),
            'reconciliation_id' => $reconciliationId,
        ]);
    }

    // NEW: Update loan balance after payment
    public function updateLoanBalance()
    {
        if ($this->loan && $this->loan_id) {
            $this->loan->refresh();
            $this->balance_before = $this->loan->remaining_balance;
            $this->balance_after = $this->loan->remaining_balance - $this->amount;
            $this->save();
        }
    }

    // NEW: Check if payment is on time
    public function isOnTime()
    {
        if (!$this->loan) {
            return true;
        }

        $dueDate = $this->loan->getDueDateForInstallment($this->installment_number);
        
        if (!$dueDate) {
            return true;
        }

        return $this->payment_date <= $dueDate;
    }

    // NEW: Calculate penalty if any
    public function calculatePenalty()
    {
        if (!$this->loan || !$this->isOnTime()) {
            $dueDate = $this->loan->getDueDateForInstallment($this->installment_number);
            $daysLate = now()->diffInDays($dueDate);
            
            // Example penalty calculation: 1% per month or 0.033% per day
            $dailyPenaltyRate = 0.00033; // ~1% per month
            $penalty = $this->amount * $dailyPenaltyRate * $daysLate;
            
            return max(0, $penalty);
        }

        return 0;
    }

    // NEW: Get payment type (with early repayment detection)
    public function getTypeAttribute()
    {
        if ($this->is_early_repayment) {
            return 'early_repayment';
        }
        
        if ($this->loan_id) {
            return 'loan_payment';
        }
        
        if ($this->savings_transaction_id) {
            return 'savings_withdrawal';
        }
        
        if ($this->expense_id) {
            return 'expense_payment';
        }

        return 'other';
    }

    public function getTypeNameAttribute()
    {
        $types = [
            'loan_payment' => 'Loan Payment',
            'early_repayment' => 'Early Repayment',
            'savings_withdrawal' => 'Savings Withdrawal',
            'expense_payment' => 'Expense Payment',
            'other' => 'Other',
        ];

        return $types[$this->type] ?? 'Unknown';
    }

    // NEW: Enhanced beneficiary name with installment info
    public function getBeneficiaryNameAttribute()
    {
        $beneficiary = 'Unknown';

        if ($this->loan && $this->loan->user) {
            $beneficiary = $this->loan->user->name;
            
            if ($this->installment_number) {
                $beneficiary .= " (Installment #{$this->installment_number})";
            }
            
            if ($this->is_early_repayment) {
                $beneficiary .= " [Early Repayment]";
            }
        } elseif ($this->savingsTransaction && $this->savingsTransaction->user) {
            $beneficiary = $this->savingsTransaction->user->name;
        } elseif ($this->expense) {
            $beneficiary = $this->expense->requestedBy->name ?? 'Expense Payment';
        }

        return $beneficiary;
    }

    public function getFormattedAmountAttribute()
    {
        return 'KES '.number_format($this->amount, 2);
    }

    // NEW: Get formatted amount with penalty
    public function getTotalAmountAttribute()
    {
        $total = $this->amount;
        
        if ($this->penalty_amount && !$this->penalty_waived) {
            $total += $this->penalty_amount;
        }
        
        return $total;
    }

    public function getFormattedTotalAmountAttribute()
    {
        return 'KES '.number_format($this->total_amount, 2);
    }

    // NEW: Check if payment covers multiple installments
    public function coversMultipleMonths()
    {
        if (!$this->loan || !$this->installment_number) {
            return false;
        }

        $monthlyPayment = $this->loan->monthly_payment;
        return $this->amount > $monthlyPayment;
    }

    // NEW: Get number of months covered by this payment
    public function getMonthsCoveredAttribute()
    {
        if (!$this->loan || !$this->coversMultipleMonths()) {
            return 1;
        }

        $monthlyPayment = $this->loan->monthly_payment;
        return floor($this->amount / $monthlyPayment);
    }

    // Boot method for auto-generating payment reference
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            // Generate payment reference
            if (empty($payment->payment_ref)) {
                $date = date('Ymd');
                $prefix = $payment->is_early_repayment ? 'EP-' : 'PAY-';
                $lastPayment = self::where('payment_ref', 'like', "{$prefix}{$date}-%")
                    ->orderBy('payment_ref', 'desc')
                    ->first();

                if ($lastPayment) {
                    $lastNumber = intval(substr($lastPayment->payment_ref, -5));
                    $sequence = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    $sequence = '00001';
                }

                $payment->payment_ref = "{$prefix}{$date}-{$sequence}";
            }

            // Set defaults
            if (empty($payment->payment_date)) {
                $payment->payment_date = now();
            }

            if (empty($payment->status)) {
                $payment->status = 'completed';
            }

            if ($payment->loan_id && empty($payment->installment_number)) {
                // Auto-determine installment number
                $lastPayment = self::where('loan_id', $payment->loan_id)
                    ->whereNotNull('installment_number')
                    ->orderBy('installment_number', 'desc')
                    ->first();
                
                $payment->installment_number = $lastPayment 
                    ? $lastPayment->installment_number + 1 
                    : 1;
            }

            // Auto-calculate penalty if applicable
            if ($payment->loan_id && $payment->status === 'completed') {
                $penalty = $payment->calculatePenalty();
                if ($penalty > 0 && !$payment->penalty_waived) {
                    $payment->penalty_amount = $penalty;
                }
            }
        });

        static::created(function ($payment) {
            // Update loan balance after payment creation
            if ($payment->loan && $payment->status === 'completed') {
                $payment->updateLoanBalance();
            }
        });

        static::updated(function ($payment) {
            // Update loan balance if payment amount or status changed
            if ($payment->loan && $payment->status === 'completed' && 
                ($payment->isDirty('amount') || $payment->isDirty('status'))) {
                $payment->updateLoanBalance();
            }
        });
    }
}