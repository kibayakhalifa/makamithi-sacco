<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'purpose',
        'application_type',
        'status',
        'applied_date',
        'approved_date',
        'approved_by',
        'disbursed_date',
        'disbursed_by',
        'next_payment_date',
        'expected_completion_date',
        'completed_date',
        'rejected_date',
        'rejected_by',
        'rejection_reason',
        'support_document',
        'parent_loan_id',
        'eligible_for_topup',
    ];

    protected $casts = [
        'paid_date' => 'datetime',
        'applied_date' => 'datetime',
        'approved_date' => 'date',
        'disbursed_date' => 'date',
        'next_payment_date' => 'date',
        'expected_completion_date' => 'date',
        'completed_date' => 'date',
        'rejected_date' => 'date',
        'amount' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_repayable' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'percentage_paid' => 'decimal:2',
    ];

    // ==================== RELATIONSHIPS ====================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('payment_date', 'asc');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function disburser()
    {
        return $this->belongsTo(User::class, 'disbursed_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function parentLoan()
    {
        return $this->belongsTo(Loan::class, 'parent_loan_id');
    }

    public function assistedBy()
    {
        return $this->belongsTo(User::class, 'assisted_by');
    }

    public function childLoans()
    {
        return $this->hasMany(Loan::class, 'parent_loan_id');
    }

    // ==================== NEW: LOAN SCHEDULE RELATIONSHIPS ====================
    public function schedules()
    {
        return $this->hasMany(LoanSchedule::class)->orderBy('installment_number');
    }

    public function nextSchedule()
    {
        return $this->hasOne(LoanSchedule::class)
            ->where('status', 'pending')
            ->orderBy('due_date');
    }

    public function overdueSchedules()
    {
        return $this->hasMany(LoanSchedule::class)
            ->where('status', 'pending')
            ->where('due_date', '<', now());
    }

    public function paidSchedules()
    {
        return $this->hasMany(LoanSchedule::class)
            ->where('status', 'paid');
    }

    // ==================== SCOPES ====================
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeDisbursed($query)
    {
        return $query->where('status', 'disbursed');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['disbursed', 'active']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDefaulted($query)
    {
        return $query->where('status', 'defaulted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ==================== METHODS ====================

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
     * Get loan type name
     */
    public function getLoanTypeNameAttribute()
    {
        $types = [
            'first_loan' => 'First Loan',
            'second_loan' => 'Second Loan',
            'topup_loan' => 'Top-up Loan',
        ];

        return $types[$this->loan_type] ?? ucfirst(str_replace('_', ' ', $this->loan_type));
    }

    /**
     * Calculate loan details (interest, total repayable, monthly payments)
     */
    public static function calculateLoanDetails($amount, $periodMonths)
    {
        $interestRate = 0.05; // 5% fixed interest
        $interestAmount = $amount * $interestRate * ($periodMonths / 12);
        $totalRepayable = $amount + $interestAmount;
        $monthlyPayment = $periodMonths > 0 ? $totalRepayable / $periodMonths : 0;

        return [
            'interest_rate' => $interestRate * 100, // 5%
            'interest_amount' => $interestAmount,
            'total_repayable' => $totalRepayable,
            'monthly_payment' => $monthlyPayment,
        ];
    }

    /**
     * Calculate due date for a specific installment
     */
    public function getDueDateForInstallment($installmentNumber = 1)
    {
        if (!$this->disbursed_date) {
            // If not disbursed yet, calculate from today
            return now()->addMonths($installmentNumber);
        }

        try {
            $disbursementDate = Carbon::parse($this->disbursed_date);
            return $disbursementDate->copy()->addMonths($installmentNumber);
        } catch (\Exception $e) {
            return now()->addMonths($installmentNumber);
        }
    }

    /**
     * Get next payment due date
     */
    public function getNextPaymentDueDate()
    {
        if (!$this->disbursed_date) {
            return null;
        }

        $disbursementDate = Carbon::parse($this->disbursed_date);
        $paymentsCount = $this->payments()->where('type', '!=', 'disbursement')->count();

        return $disbursementDate->copy()->addMonths($paymentsCount + 1);
    }

    /**
     * Check if loan is overdue
     */
    public function isOverdue()
    {
        if (!$this->next_payment_date || $this->status !== 'disbursed') {
            return false;
        }

        return Carbon::parse($this->next_payment_date)->isPast();
    }

    /**
     * Get days overdue
     */
    public function getDaysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return Carbon::parse($this->next_payment_date)->diffInDays(now());
    }

    /**
     * Update loan status based on payment progress
     */
    public function updateStatus()
    {
        if ($this->remaining_balance <= 0) {
            $this->update([
                'status' => 'completed',
                'completed_date' => now(),
            ]);
            return;
        }

        if ($this->isOverdue() && $this->getDaysOverdue() > 30) {
            $this->update(['status' => 'defaulted']);
            return;
        }

        // Keep current status if disbursed
        if ($this->status === 'disbursed') {
            return;
        }
    }

    /**
     * Recalculate loan after early payment
     */
    public function recalculateForEarlyPayment($extraPayment)
    {
        $newRemainingBalance = $this->remaining_balance - $extraPayment;
        $monthsRemaining = $this->months_remaining - 1; // Reduce by one month

        if ($monthsRemaining <= 0) {
            return [
                'new_monthly_payment' => 0,
                'months_remaining' => 0,
            ];
        }

        $newMonthlyPayment = $newRemainingBalance / $monthsRemaining;

        return [
            'new_monthly_payment' => $newMonthlyPayment,
            'months_remaining' => $monthsRemaining,
        ];
    }

    /**
     * Check if loan qualifies for top-up
     */
    public function qualifiesForTopUp()
    {
        // Loan must be at least 50% paid
        if ($this->percentage_paid < 50) {
            return false;
        }

        // Loan must be active
        if (!in_array($this->status, ['disbursed', 'active'])) {
            return false;
        }

        // No defaults
        if ($this->status === 'defaulted') {
            return false;
        }

        // Not already have a top-up loan
        if ($this->childLoans()->whereIn('status', ['pending', 'approved', 'disbursed'])->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Calculate total interest paid
     */
    public function getTotalInterestPaid()
    {
        return $this->payments()->sum('interest');
    }

    /**
     * Calculate total principal paid
     */
    public function getTotalPrincipalPaid()
    {
        return $this->payments()->sum('principal');
    }

    /**
     * Generate loan number
     */
    public static function generateLoanNumber()
    {
        $prefix = 'LN';
        $year = date('Y');
        $month = date('m');
        $sequence = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        return $prefix . '-' . $year . $month . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get loan progress percentage
     */
    public function getProgressPercentage()
    {
        if ($this->total_repayable <= 0) {
            return 0;
        }

        $paid = $this->total_repayable - $this->remaining_balance;
        return ($paid / $this->total_repayable) * 100;
    }

    /**
     * Get formatted status with badge color
     */
    public function getStatusBadge()
    {
        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'disbursed' => 'bg-green-100 text-green-800',
            'active' => 'bg-green-100 text-green-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'defaulted' => 'bg-red-100 text-red-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        $color = $statusColors[$this->status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $color . '">' .
            ucfirst($this->status) . '</span>';
    }

    /**
     * Calculate remaining months accurately
     */
    public function calculateRemainingMonths()
    {
        if ($this->remaining_balance <= 0) {
            return 0;
        }

        if ($this->monthly_payment <= 0) {
            return $this->period_months - $this->months_paid;
        }

        return ceil($this->remaining_balance / $this->monthly_payment);
    }

    /**
     * Get payment schedule
     */
    public function getPaymentSchedule()
    {
        $schedule = [];
        $balance = $this->total_repayable;
        $monthlyPayment = $this->monthly_payment;
        $disbursementDate = $this->disbursed_date ? Carbon::parse($this->disbursed_date) : now();

        for ($i = 1; $i <= $this->period_months; $i++) {
            $dueDate = $disbursementDate->copy()->addMonths($i);
            $balance = max(0, $balance - $monthlyPayment);

            $schedule[] = [
                'installment' => $i,
                'due_date' => $dueDate,
                'amount' => $monthlyPayment,
                'remaining_balance' => $balance,
            ];
        }

        return $schedule;
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            if (empty($loan->loan_number)) {
                $loan->loan_number = self::generateLoanNumber();
            }
        });

        static::created(function ($loan) {
            // Set initial values
            $loan->update([
                'remaining_balance' => $loan->total_repayable,
                'months_remaining' => $loan->period_months,
                'percentage_paid' => 0,
            ]);
        });
    }

    /**
     * Accessor for formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'KES ' . number_format($this->amount, 2);
    }

    /**
     * Accessor for formatted total repayable
     */
    public function getFormattedTotalRepayableAttribute()
    {
        return 'KES ' . number_format($this->total_repayable, 2);
    }

    /**
     * Accessor for formatted monthly payment
     */
    public function getFormattedMonthlyPaymentAttribute()
    {
        return 'KES ' . number_format($this->monthly_payment, 2);
    }

    /**
     * Accessor for formatted remaining balance
     */
    public function getFormattedRemainingBalanceAttribute()
    {
        return 'KES ' . number_format($this->remaining_balance, 2);
    }

    /**
     * Accessor for formatted amount paid
     */
    public function getFormattedAmountPaidAttribute()
    {
        return 'KES ' . number_format($this->amount_paid, 2);
    }

    // ==================== NEW: LOAN SCHEDULE METHODS ====================

    /**
     * Generate loan schedule when loan is disbursed
     */
    public function generateSchedule()
    {
        if ($this->schedules()->exists()) {
            return $this->schedules;
        }

        $monthlyPayment = $this->monthly_payment;
        $startDate = $this->disbursed_date ? \Carbon\Carbon::parse($this->disbursed_date) : now();

        for ($i = 1; $i <= $this->period_months; $i++) {
            LoanSchedule::create([
                'loan_id' => $this->id,
                'installment_number' => $i,
                'due_date' => $startDate->copy()->addMonths($i),
                'amount_due' => $monthlyPayment,
                'status' => 'pending',
            ]);
        }

        return $this->schedules;
    }
    public function recalculateAfterPayment($paymentAmount)
    {
        // If payment is exactly monthly or less, just mark as paid
        if ($paymentAmount <= $this->monthly_payment) {
            return false;
        }

        // Extra payment made
        $extraAmount = $paymentAmount - $this->monthly_payment;
        $this->remaining_balance -= $extraAmount;

        // Recalculate new monthly payment
        $remainingMonths = $this->period_months - $this->months_paid - 1; // -1 because we just paid current month

        if ($remainingMonths > 0) {
            $newMonthly = ceil($this->remaining_balance / $remainingMonths);

            // Update all future schedules
            $this->schedules()
                ->where('status', 'pending')
                ->where('installment_number', '>', $this->months_paid)
                ->update(['amount_due' => $newMonthly]);

            $this->monthly_payment = $newMonthly;
        }

        $this->save();
        return true;
    }

    /**
     * Get simple payment schedule for display
     */
    public function getSimpleSchedule()
    {
        $schedules = $this->schedules()->orderBy('installment_number')->get();
        $payments = $this->payments()->where('status', 'completed')->get();

        // Apply payments to schedules
        foreach ($schedules as $schedule) {
            $payment = $payments->firstWhere('installment_number', $schedule->installment_number);

            if ($payment) {
                $schedule->status = 'paid';
                $schedule->amount_paid = $payment->amount;
                $schedule->paid_date = $payment->payment_date;
            } elseif ($schedule->due_date < now()) {
                $schedule->status = 'overdue';
            }
        }

        return $schedules;
    }
    // In LoanSchedule model
    public function adjustedBy()
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }
    /**
     * Adjust schedule after extra/early payment - UPDATE DATABASE RECORDS
     */
    public function adjustScheduleAfterPayment($extraAmount, $paymentDate = null)
    {
        // Get pending schedules
        $pendingSchedules = $this->schedules()->pending()->orderBy('installment_number')->get();

        if ($pendingSchedules->isEmpty()) {
            return false;
        }

        // Calculate new remaining balance after extra payment
        $newRemainingBalance = $this->remaining_balance - $extraAmount;

        if ($newRemainingBalance <= 0) {
            // Loan fully paid - mark all as paid
            foreach ($pendingSchedules as $schedule) {
                $schedule->update([
                    'status' => 'paid',
                    'amount_paid' => 0,
                    'paid_date' => $paymentDate ?? now(),
                    'adjustment_notes' => 'Loan fully paid via early repayment',
                ]);
            }
            return true;
        }

        // Calculate new monthly payment
        $remainingMonths = $pendingSchedules->count();
        $newMonthlyPayment = ceil($newRemainingBalance / $remainingMonths);

        // Recalculate principal and interest proportionally
        $principalRatio = $this->amount / $this->total_repayable;
        $interestRatio = $this->interest_amount / $this->total_repayable;

        $newPrincipalPerMonth = $newMonthlyPayment * $principalRatio;
        $newInterestPerMonth = $newMonthlyPayment * $interestRatio;

        // ACTUALLY UPDATE THE DATABASE RECORDS
        $runningBalance = $newRemainingBalance;
        foreach ($pendingSchedules as $schedule) {
            $balanceAfter = max(0, $runningBalance - $newMonthlyPayment);

            $schedule->update([
                'amount_due' => $newMonthlyPayment,
                'principal' => $newPrincipalPerMonth,
                'interest' => $newInterestPerMonth,
                'balance_before' => $runningBalance + $newMonthlyPayment,
                'balance_after' => $balanceAfter,
                'is_adjusted' => true,
                'adjustment_notes' => 'Schedule adjusted after extra payment of KES ' .
                    number_format($extraAmount, 2) . ' on ' . ($paymentDate ? $paymentDate->format('d M Y') : now()->format('d M Y')),
            ]);

            $runningBalance = $balanceAfter;
        }

        // Update loan's monthly payment in the database
        $this->update([
            'monthly_payment' => $newMonthlyPayment,
            'remaining_balance' => $newRemainingBalance,
        ]);

        return true;
    }
    /**
     * Get dynamic payment schedule considering payments made AND adjustments
     */
    public function getDynamicPaymentSchedule()
    {
        // Ensure schedule exists
        if ($this->schedules->isEmpty() && $this->status === 'disbursed') {
            $this->generateSchedule();
        }

        // Get all payments
        $payments = $this->payments()
            ->where('status', 'completed')
            ->orderBy('payment_date')
            ->get();

        // Calculate adjusted monthly payment based on current state
        $remainingBalance = $this->remaining_balance;
        $remainingMonths = max(1, $this->period_months - $this->months_paid);
        $adjustedMonthly = $remainingMonths > 0 ? ceil($remainingBalance / $remainingMonths) : 0;

        // Update schedule based on payments AND adjustments
        $updatedSchedules = [];
        $runningBalance = $this->total_repayable;

        foreach ($this->schedules()->orderBy('installment_number')->get() as $schedule) {
            // Check if there's a payment for this installment
            $payment = $payments->first(function ($payment) use ($schedule) {
                return $payment->installment_number == $schedule->installment_number;
            });

            if ($payment) {
                $schedule->status = 'paid';
                $schedule->amount_paid = $payment->amount;
                $schedule->paid_date = $payment->payment_date;
                $schedule->payment_reference = $payment->payment_ref;
                $runningBalance -= $payment->amount;

                // Update schedule amount if it was adjusted
                if ($schedule->is_adjusted) {
                    $schedule->amount_due = $adjustedMonthly;
                }
            } elseif ($schedule->due_date < now() && $schedule->status == 'pending') {
                $schedule->status = 'overdue';

                // Update amount for pending schedules that need adjustment
                if ($this->months_paid > 0 && $schedule->installment_number > $this->months_paid) {
                    $schedule->amount_due = $adjustedMonthly;
                }
            } else {
                // For future pending schedules, apply adjusted amount
                if ($schedule->status == 'pending' && $schedule->installment_number > $this->months_paid) {
                    $schedule->amount_due = $adjustedMonthly;
                }
            }

            // Update balances
            $schedule->balance_before = $runningBalance + $schedule->amount_due;
            $schedule->balance_after = $runningBalance;

            // Only decrement balance if this installment should have been paid
            if ($schedule->installment_number <= $this->months_paid) {
                $runningBalance -= $schedule->amount_due;
            }

            $updatedSchedules[] = $schedule;
        }

        return collect($updatedSchedules);
    }

    /**
     * Get next due payment
     */
    public function getNextPayment()
    {
        return $this->schedules()
            ->pending()
            ->orderBy('due_date')
            ->first();
    }

    /**
     * Get overdue schedules
     */
    public function getOverdueSchedules()
    {
        return $this->schedules()
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->get();
    }
}