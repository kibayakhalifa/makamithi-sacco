<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saving_id',
        'amount',
        'withdrawal_reason',
        'payment_method',
        'bank_account_name',
        'bank_name',
        'bank_account_number',
        'bank_branch',
        'mpesa_number',
        'status',
        'requested_at',
        'processed_at',
        'processed_by',
        'notes',
        'rejection_reason',
        'available_savings', // Make sure this is added
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'available_savings' => 'decimal:2', // Add this
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // CHANGE THIS METHOD NAME - from saving() to savingsAccount()
    public function savingsAccount()
    {
        return $this->belongsTo(Saving::class, 'saving_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    // Add this method for easier status checking
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}