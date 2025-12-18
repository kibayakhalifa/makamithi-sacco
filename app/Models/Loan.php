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
        'applied_date' => 'date',
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

    public function childLoans()
    {
        return $this->hasMany(Loan::class, 'parent_loan_id');
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
}