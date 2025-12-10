<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'cheque_number',
        'loan_id',
        'savings_withdrawal_id',
        'expense_id',
        'user_id',
        'bank_name',
        'bank_branch',
        'account_number',
        'amount',
        'purpose',
        'status',
        'issue_date',
        'issued_by',
        'issue_notes',
        'clearance_date',
        'cleared_by',
        'clearance_notes',
        'cancelled_date',
        'cancelled_by',
        'cancellation_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'issue_date' => 'date',
        'clearance_date' => 'date',
        'cancelled_date' => 'date',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function savingsTransaction()
    {
        return $this->belongsTo(SavingsTransaction::class, 'savings_withdrawal_id');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function clearedBy()
    {
        return $this->belongsTo(User::class, 'cleared_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    // Scopes
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopeCleared($query)
    {
        return $query->where('status', 'cleared');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeByBank($query, $bankName)
    {
        return $query->where('bank_name', 'LIKE', "%{$bankName}%");
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('issue_date', [$startDate, $endDate]);
    }

    // Methods
    public function markAsCleared($userId, $clearanceDate = null, $notes = null)
    {
        $this->update([
            'status' => 'cleared',
            'clearance_date' => $clearanceDate ?? now(),
            'cleared_by' => $userId,
            'clearance_notes' => $notes,
        ]);
    }

    public function cancel($userId, $reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_date' => now(),
            'cancelled_by' => $userId,
            'cancellation_reason' => $reason,
        ]);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'issued' => ['class' => 'bg-orange-100 text-orange-800', 'text' => 'Issued'],
            'cleared' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Cleared'],
            'cancelled' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled'],
        ];
        
        return $badges[$this->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Unknown'];
    }

    public function getDaysOutstandingAttribute()
    {
        if ($this->status !== 'issued' || !$this->issue_date) {
            return 0;
        }
        
        return now()->diffInDays($this->issue_date);
    }

    public function getPurposeNameAttribute()
    {
        $purposes = [
            'loan_disbursement' => 'Loan Disbursement',
            'savings_withdrawal' => 'Savings Withdrawal',
            'expense_payment' => 'Expense Payment',
            'other' => 'Other',
        ];
        
        return $purposes[$this->purpose] ?? 'Unknown';
    }

    public function getFormattedAmountAttribute()
    {
        return 'KES ' . number_format($this->amount, 2);
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

    public function isOverdue($daysThreshold = 30)
    {
        return $this->status === 'issued' && 
               $this->getDaysOutstandingAttribute() > $daysThreshold;
    }
}