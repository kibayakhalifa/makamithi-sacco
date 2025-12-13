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

    public function reconciliation()
    {
        return $this->belongsTo(BankReconciliation::class);
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

    public function scopeReconciled($query)
    {
        return $query->where('reconciled', true);
    }

    public function scopeUnreconciled($query)
    {
        return $this->where('reconciled', false)
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

    // Methods
    public function markAsReconciled($reconciliationId = null)
    {
        $this->update([
            'reconciled' => true,
            'reconciled_at' => now(),
            'reconciliation_id' => $reconciliationId,
        ]);
    }

    public function getTypeAttribute()
    {
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
            'savings_withdrawal' => 'Savings Withdrawal',
            'expense_payment' => 'Expense Payment',
            'other' => 'Other',
        ];

        return $types[$this->type] ?? 'Unknown';
    }

    public function getBeneficiaryNameAttribute()
    {
        if ($this->loan && $this->loan->user) {
            return $this->loan->user->name;
        }

        if ($this->savingsTransaction && $this->savingsTransaction->user) {
            return $this->savingsTransaction->user->name;
        }

        if ($this->expense) {
            return $this->expense->requestedBy->name ?? 'Expense Payment';
        }

        return 'Unknown';
    }

    public function getFormattedAmountAttribute()
    {
        return 'KES '.number_format($this->amount, 2);
    }

    // Add this method to your existing Payment class:
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_ref)) {
                $date = date('Ymd');
                $lastPayment = self::where('payment_ref', 'like', "PAY-{$date}-%")
                    ->orderBy('payment_ref', 'desc')
                    ->first();

                if ($lastPayment) {
                    $lastNumber = intval(substr($lastPayment->payment_ref, -5));
                    $sequence = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    $sequence = '00001';
                }

                $payment->payment_ref = "PAY-{$date}-{$sequence}";
            }

            // Set defaults
            if (empty($payment->payment_date)) {
                $payment->payment_date = now();
            }

            if (empty($payment->status)) {
                $payment->status = 'completed';
            }
        });
    }
}
