<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saving_id',
        'transaction_type', // 'deposit', 'withdrawal', 'interest', 'adjustment'
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'description',
        'transaction_date',
        'processed_by',
        'approved_by',
        'status', // 'pending', 'completed', 'rejected'
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
        return $query->where('transaction_type', 'deposit');
    }

    public function scopeWithdrawals($query)
    {
        return $query->where('transaction_type', 'withdrawal');
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
            'saving_id' => $data['saving_id'],
            'transaction_type' => $data['transaction_type'],
            'amount' => $data['amount'],
            'balance_before' => $data['balance_before'],
            'balance_after' => $data['balance_after'],
            'reference' => $data['reference'] ?? uniqid('TRX-'),
            'description' => $data['description'],
            'transaction_date' => $data['transaction_date'] ?? now(),
            'processed_by' => $data['processed_by'] ?? auth()->id(),
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