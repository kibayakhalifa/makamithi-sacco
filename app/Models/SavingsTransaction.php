<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_ref',
        'type', // 'payroll_deduction', 'voluntary_deposit', 'withdrawal', 'interest_credit', 'adjustment'
        'amount',
        'balance_before',
        'balance_after',
        'status', // 'pending', 'completed', 'failed', 'reversed'
        'description',
        'payment_method',
        'reference_number',
        'transaction_date',
        'posted_date',
        'posted_by',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingsAccount()
    {
        return $this->belongsTo(Saving::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ========== SCOPES ==========
    
    public function scopeDeposits($query)
    {
        return $query->whereIn('type', ['payroll_deduction', 'voluntary_deposit', 'interest_credit']);
    }

    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdrawal');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    // ========== HELPER METHODS ==========
    
    /**
     * Create a transaction record
     */
    public static function recordTransaction($data)
    {
        return self::create([
            'user_id' => $data['user_id'],
            'transaction_ref' => $data['transaction_ref'] ?? 'TRX-' . uniqid(),
            'type' => $data['type'],
            'amount' => $data['amount'],
            'balance_before' => $data['balance_before'],
            'balance_after' => $data['balance_after'],
            'reference_number' => $data['reference_number'] ?? null,
            'description' => $data['description'] ?? null,
            'transaction_date' => $data['transaction_date'] ?? now()->toDateString(),
            'posted_by' => $data['posted_by'] ?? auth()->id(),
            'status' => $data['status'] ?? 'completed',
        ]);
    }

    /**
     * Check if transaction can be reversed
     */
    public function canBeReversed()
    {
        return $this->status === 'completed' && 
               $this->transaction_date->diffInDays(now()) <= 30; // Within 30 days
    }
}