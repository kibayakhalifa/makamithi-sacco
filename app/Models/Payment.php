<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'covers_installments', // JSON array of installment numbers covered
        'is_schedule_adjusted', // Flag if schedule was adjusted after this payment
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
        'is_schedule_adjusted' => 'boolean',
        // NEW CASTS
        'installment_number' => 'integer',
        'month_covered' => 'date',
        'covers_installments' => 'array',
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

    // NEW: Relationship to covered schedules (for payments covering multiple installments)
    public function coveredSchedules()
    {
        if (!$this->covers_installments || empty($this->covers_installments)) {
            return collect();
        }

        return LoanSchedule::where('loan_id', $this->loan_id)
            ->whereIn('installment_number', $this->covers_installments)
            ->get();
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

    // NEW: Scope for payments that adjusted schedule
    public function scopeAdjustedSchedule($query)
    {
        return $query->where('is_schedule_adjusted', true);
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
        if ($this->loan && $this->loan_id && $this->status === 'completed') {
            $loan = $this->loan;
            
            // Calculate principal and interest if not set
            if (!$this->principal || !$this->interest) {
                $this->calculatePrincipalInterest();
            }
            
            // Update loan amounts
            $loan->amount_paid += $this->amount;
            $loan->remaining_balance = max(0, $loan->total_repayable - $loan->amount_paid);
            $loan->percentage_paid = ($loan->amount_paid / $loan->total_repayable) * 100;
            
            // Update months paid if this is a regular payment
            if ($this->installment_number && !$this->is_early_repayment) {
                $loan->months_paid = $loan->payments()
                    ->where('status', 'completed')
                    ->where('is_early_repayment', false)
                    ->count();
                $loan->months_remaining = max(0, $loan->period_months - $loan->months_paid);
            }
            
            $loan->save();
            
            // Update payment balances
            $this->balance_before = $loan->remaining_balance + $this->amount;
            $this->balance_after = $loan->remaining_balance;
            $this->save();
        }
    }

    // NEW: Calculate principal and interest portions
    public function calculatePrincipalInterest()
    {
        if (!$this->loan) {
            return;
        }
        
        $loan = $this->loan;
        $totalRepayable = $loan->total_repayable;
        
        // Calculate proportions
        $principalRatio = $loan->amount / $totalRepayable;
        $interestRatio = $loan->interest_amount / $totalRepayable;
        
        $this->principal = $this->amount * $principalRatio;
        $this->interest = $this->amount * $interestRatio;
        $this->save();
    }

    // NEW: Update loan schedule after payment
    // In your Payment model, update the updateLoanSchedule method:

public function updateLoanSchedule()
{
    if (!$this->loan || $this->status !== 'completed') {
        return;
    }
    
    $loan = $this->loan;
    
    // If this is a regular installment payment
    if ($this->installment_number && !$this->is_early_repayment) {
        $schedule = LoanSchedule::where('loan_id', $loan->id)
            ->where('installment_number', $this->installment_number)
            ->first();
            
        if ($schedule && $schedule->status === 'pending') {
            $schedule->markAsPaid([
                'amount_paid' => $this->amount,
                'paid_date' => $this->payment_date,
                'payment_reference' => $this->payment_ref,
                'notes' => 'Paid via ' . $this->payment_method . ' - Ref: ' . $this->payment_ref,
            ]);
            
            // Update covered installments if payment covers multiple months
            $this->updateCoveredInstallments();
        }
    } 
    // If this is an early/extra repayment
    elseif ($this->is_early_repayment || $this->amount > $loan->monthly_payment) {
        $this->adjustScheduleForExtraPayment();
    }
}

    // NEW: Handle payments covering multiple installments
    private function updateCoveredInstallments()
    {
        if (!$this->loan || $this->amount <= $this->loan->monthly_payment) {
            return;
        }
        
        $loan = $this->loan;
        $monthlyPayment = $loan->monthly_payment;
        
        // Calculate how many months this payment covers
        $monthsCovered = floor($this->amount / $monthlyPayment);
        
        if ($monthsCovered > 1) {
            $coveredInstallments = [];
            $currentInstallment = $this->installment_number;
            
            // Mark next installments as paid
            for ($i = 0; $i < $monthsCovered; $i++) {
                $installmentNum = $currentInstallment + $i;
                $schedule = LoanSchedule::where('loan_id', $loan->id)
                    ->where('installment_number', $installmentNum)
                    ->first();
                    
                if ($schedule && $schedule->status === 'pending') {
                    $schedule->markAsPaid([
                        'amount_paid' => $monthlyPayment,
                        'paid_date' => $this->payment_date,
                        'notes' => 'Covered by payment #' . $this->payment_ref,
                    ]);
                    $coveredInstallments[] = $installmentNum;
                }
            }
            
            // Update payment with covered installments
            $this->covers_installments = $coveredInstallments;
            $this->save();
            
            // If there's excess amount, it's an early repayment
            $excessAmount = $this->amount - ($monthlyPayment * $monthsCovered);
            if ($excessAmount > 0) {
                $loan->adjustScheduleAfterPayment($excessAmount, $this->payment_date);
                $this->is_schedule_adjusted = true;
                $this->save();
            }
        }
    }

    // NEW: Adjust schedule for extra/early payments
    private function adjustScheduleForExtraPayment()
    {
        if (!$this->loan) {
            return;
        }
        
        $loan = $this->loan;
        $extraAmount = $this->amount;
        
        // If this payment has an installment number, subtract that month's payment first
        if ($this->installment_number) {
            $schedule = LoanSchedule::where('loan_id', $loan->id)
                ->where('installment_number', $this->installment_number)
                ->first();
                
            if ($schedule && $schedule->status === 'pending') {
                $schedule->markAsPaid([
                    'amount_paid' => min($this->amount, $schedule->amount_due),
                    'paid_date' => $this->payment_date,
                    'notes' => 'Paid via ' . $this->payment_method,
                ]);
                
                $extraAmount -= $schedule->amount_due;
            }
        }
        
        // If there's still extra amount, adjust the schedule
        if ($extraAmount > 0) {
            $loan->adjustScheduleAfterPayment($extraAmount, $this->payment_date);
            $this->is_schedule_adjusted = true;
            $this->is_early_repayment = true;
            $this->save();
        }
    }

    // NEW: Check if payment is on time
    public function isOnTime()
    {
        if (!$this->loan || !$this->installment_number) {
            return true;
        }

        $schedule = LoanSchedule::where('loan_id', $this->loan_id)
            ->where('installment_number', $this->installment_number)
            ->first();

        if (!$schedule || !$this->payment_date) {
            return true;
        }

        $paymentDate = Carbon::parse($this->payment_date);
        $dueDate = Carbon::parse($schedule->due_date);
        
        return $paymentDate->lte($dueDate);
    }

    // NEW: Calculate penalty if any
    public function calculatePenalty()
    {
        // Only calculate penalty for loan payments
        if (!$this->loan || !$this->loan_id || !$this->installment_number) {
            return 0;
        }

        $schedule = LoanSchedule::where('loan_id', $this->loan_id)
            ->where('installment_number', $this->installment_number)
            ->first();

        if (!$schedule || !$this->payment_date) {
            return 0;
        }

        $paymentDate = Carbon::parse($this->payment_date);
        $dueDate = Carbon::parse($schedule->due_date);

        // Check if payment is late
        if ($paymentDate->greaterThan($dueDate)) {
            $daysLate = $dueDate->diffInDays($paymentDate);
            
            // Penalty: 1% per month or ~0.033% per day
            $dailyPenaltyRate = 0.00033;
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
            
            if ($this->covers_installments && count($this->covers_installments) > 1) {
                $beneficiary .= " [Covers installments: " . implode(', ', $this->covers_installments) . "]";
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
        return 'KES ' . number_format($this->amount, 2);
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
        return 'KES ' . number_format($this->total_amount, 2);
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

    // NEW: Get status badge with colors
    public function getStatusBadgeAttribute()
    {
        $statusConfig = [
            'completed' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Completed'],
            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'Pending'],
            'failed' => ['class' => 'bg-red-100 text-red-800', 'label' => 'Failed'],
        ];

        $config = $statusConfig[$this->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'label' => ucfirst($this->status)];

        return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $config['class'] . '">' . $config['label'] . '</span>';
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

            // Set payment date default
            if (empty($payment->payment_date)) {
                $payment->payment_date = now();
            }

            // Set default status to pending
            if (empty($payment->status)) {
                $payment->status = 'pending';
            }

            // Calculate penalty if not set
            if ($payment->loan_id && empty($payment->penalty_amount)) {
                $payment->penalty_amount = $payment->calculatePenalty();
            }
        });

        static::created(function ($payment) {
            // Update loan balance and schedule if payment is completed
            if ($payment->loan && $payment->status === 'completed') {
                $payment->updateLoanBalance();
                $payment->updateLoanSchedule();
            }
        });

        static::updated(function ($payment) {
            // If status changed to completed, update balance and schedule
            if ($payment->loan && $payment->wasChanged('status') && $payment->status === 'completed') {
                $payment->updateLoanBalance();
                $payment->updateLoanSchedule();
            }
            
            // If amount changed, recalculate penalty
            if ($payment->loan_id && $payment->wasChanged('amount')) {
                $payment->penalty_amount = $payment->calculatePenalty();
                $payment->saveQuietly(); // Use quietly to avoid recursion
            }
        });
    }
}