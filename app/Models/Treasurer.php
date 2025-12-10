<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasurer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_date',
        'term_end_date',
        'status',
        'signatory_limit',
        'bank_signatory',
        'can_issue_cheques',
        'can_approve_expenses',
        'can_process_loans',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'term_end_date' => 'date',
        'signatory_limit' => 'decimal:2',
        'bank_signatory' => 'boolean',
        'can_issue_cheques' => 'boolean',
        'can_approve_expenses' => 'boolean',
        'can_process_loans' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issuedCheques()
    {
        return $this->hasMany(ChequeRecord::class, 'issued_by');
    }

    public function clearedCheques()
    {
        return $this->hasMany(ChequeRecord::class, 'cleared_by');
    }

    public function cancelledCheques()
    {
        return $this->hasMany(ChequeRecord::class, 'cancelled_by');
    }

    public function processedPayments()
    {
        return $this->hasMany(Payment::class, 'posted_by');
    }

    public function approvedExpenses()
    {
        return $this->hasMany(Expense::class, 'approved_by');
    }

    public function paidExpenses()
    {
        return $this->hasMany(Expense::class, 'paid_by');
    }

    public function performedReconciliations()
    {
        return $this->hasMany(BankReconciliation::class, 'performed_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCanApproveExpenses($query)
    {
        return $query->where('can_approve_expenses', true);
    }

    public function scopeCanIssueCheques($query)
    {
        return $query->where('can_issue_cheques', true);
    }

    // Methods
    public function getFullNameAttribute()
    {
        return $this->user->name ?? 'Unknown';
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? 'Unknown';
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone ?? 'Unknown';
    }

    public function getEmployeeNumberAttribute()
    {
        return $this->user->employee_number ?? 'Unknown';
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->term_end_date > now();
    }

    public function canApproveAmount($amount)
    {
        return $this->can_approve_expenses && 
               ($this->signatory_limit === null || $amount <= $this->signatory_limit);
    }

    public function getTenureInMonthsAttribute()
    {
        if (!$this->appointment_date) return 0;
        
        $start = $this->appointment_date;
        $end = $this->term_end_date ?? now();
        
        return $start->diffInMonths($end);
    }

    public function getTotalChequesIssuedAttribute()
    {
        return $this->issuedCheques()->count();
    }

    public function getTotalPaymentsProcessedAttribute()
    {
        return $this->processedPayments()->count();
    }

    public function getTotalAmountProcessedAttribute()
    {
        return $this->processedPayments()->sum('amount');
    }

    // Check if treasurer has permission for specific actions
    public function canProcessLoan($loanAmount = null)
    {
        if (!$this->can_process_loans) return false;
        
        if ($loanAmount && $this->signatory_limit) {
            return $loanAmount <= $this->signatory_limit;
        }
        
        return true;
    }

    public function canReconcileBank()
    {
        return $this->isActive() && $this->bank_signatory;
    }
}