<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanTopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'purpose',
        'repayment_period',
        'interest_rate',
        'status',
        'applied_at',
        'approved_at',
        'approved_by',
        'disbursed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'applied_at' => 'datetime',
        'approved_at' => 'datetime',
        'disbursed_at' => 'datetime',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}