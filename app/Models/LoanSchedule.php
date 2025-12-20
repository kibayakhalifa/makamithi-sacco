<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanSchedule extends Model
{
    use HasFactory;

    // KEEP IT SIMPLE - just what we need
    protected $fillable = [
        'loan_id',
        'installment_number',
        'due_date',
        'amount_due',      // This is the total (principal + interest)
        'status',
        'paid_date',
        'amount_paid',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date < now();
    }
}