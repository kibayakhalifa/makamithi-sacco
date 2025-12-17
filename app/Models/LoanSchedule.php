<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'installment_number',
        'due_date',
        'amount_due',
        'principal_due',
        'interest_due',
        'status',
        'paid_date',
        'amount_paid',
        'penalty_amount',
        'remaining_balance',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount_due' => 'decimal:2',
        'principal_due' => 'decimal:2',
        'interest_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'installment_number', 'installment_number')
            ->where('loan_id', $this->loan_id);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
            ->where('due_date', '<', now());
    }

    public function markAsPaid($paymentAmount = null, $paymentDate = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_date' => $paymentDate ?? now(),
            'amount_paid' => $paymentAmount ?? $this->amount_due,
        ]);
    }
}