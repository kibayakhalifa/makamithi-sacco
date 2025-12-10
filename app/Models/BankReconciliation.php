<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReconciliation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reconciliation_date',
        'bank_statement_balance',
        'system_balance',
        'difference',
        'status',
        'performed_by',
        'notes',
        'statement_file_path',
    ];

    protected $casts = [
        'reconciliation_date' => 'date',
        'bank_statement_balance' => 'decimal:2',
        'system_balance' => 'decimal:2',
        'difference' => 'decimal:2',
    ];

    // Relationships
    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeBalanced($query)
    {
        return $query->where('status', 'balanced');
    }

    public function scopeUnbalanced($query)
    {
        return $query->where('status', 'unbalanced');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('reconciliation_date', [$startDate, $endDate]);
    }

    // Methods
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'balanced' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Balanced'],
            'unbalanced' => ['class' => 'bg-orange-100 text-orange-800', 'text' => 'Unbalanced'],
        ];
        
        return $badges[$this->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Unknown'];
    }

    public function getFormattedBankBalanceAttribute()
    {
        return 'KES ' . number_format($this->bank_statement_balance, 2);
    }

    public function getFormattedSystemBalanceAttribute()
    {
        return 'KES ' . number_format($this->system_balance, 2);
    }

    public function getFormattedDifferenceAttribute()
    {
        $sign = $this->difference >= 0 ? '+' : '';
        return $sign . 'KES ' . number_format(abs($this->difference), 2);
    }

    public function getDifferenceColorClassAttribute()
    {
        if ($this->difference == 0) return 'text-green-600';
        if ($this->difference > 0) return 'text-orange-600'; // System has less
        return 'text-red-600'; // System has more
    }

    public function getUnreconciledTransactionsCountAttribute()
    {
        return Payment::unreconciled()
            ->where('payment_date', '<=', $this->reconciliation_date)
            ->count();
    }

    public function reconcileTransactions($transactionIds)
    {
        $count = 0;
        
        foreach ($transactionIds as $transactionId) {
            $payment = Payment::find($transactionId);
            if ($payment && !$payment->reconciled) {
                $payment->markAsReconciled($this->id);
                $count++;
            }
        }
        
        return $count;
    }
}