<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_number',
        'national_id',
        'department',
        'position',
        'employment_date',
        'monthly_salary',
        'monthly_savings',
        'date_of_birth',
        'phone', // Note: this is 'phone' not 'phone_number'
        'address',
        'sacco_status',
        'role',
        'sacco_join_date',
        'sacco_exit_date',
        'exit_reason',
        'approved_by',
        'approved_at',
        'profile_photo_path', // Add this for profile photos
        'national_id_image', // Add this for national ID images
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'monthly_salary' => 'decimal:2',
        'monthly_savings' => 'decimal:2',
        'employment_date' => 'date',
        'date_of_birth' => 'date',
        'sacco_join_date' => 'date',
        'sacco_exit_date' => 'date',
        'approved_at' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========

    public function savings()
    {
        return $this->hasOne(Saving::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoan()
    {
        return $this->hasOne(Loan::class)->whereIn('status', ['active', 'disbursed']);
    }

    public function nextOfKin()
    {
        return $this->hasOne(NextOfKin::class);
    }

    public function savingsTransactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function memberApproval()
    {
        return $this->hasOne(MemberApproval::class);
    }

    public function chequeRecords()
    {
        return $this->hasMany(ChequeRecord::class);
    }

    public function submittedMembers()
    {
        return $this->hasMany(MemberApproval::class, 'submitted_by');
    }

    public function approvedMembers()
    {
        return $this->hasMany(MemberApproval::class, 'approved_by');
    }

    public function assistedLoans()
    {
        return $this->hasMany(Loan::class, 'assisted_by');
    }

    public function approvedLoans()
    {
        return $this->hasMany(Loan::class, 'approved_by');
    }

    public function disbursedLoans()
    {
        return $this->hasMany(Loan::class, 'disbursed_by');
    }

    public function treasurer()
    {
        return $this->hasOne(Treasurer::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    // ========== SCOPES ==========

    public function scopeMembers($query)
    {
        return $this->role === 'member' ?? $query->where('role', 'member');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('sacco_status', 'pending');
    }

    public function scopeActiveMembers($query)
    {
        return $query->where('sacco_status', 'active');
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    // ========== HELPER METHODS ==========

    /**
     * Calculate loan eligibility (1.5× savings rule)
     */
    public function getLoanEligibilityAttribute()
    {
        if (! $this->savings) {
            return 0;
        }

        return $this->savings->available_savings * 1.5;
    }

    /**
     * Check if member has paid 50% of their active loan (for top-up eligibility)
     */
    public function isEligibleForTopUp()
    {
        $activeLoan = $this->activeLoan;

        if (! $activeLoan) {
            return false;
        }

        return $activeLoan->percentage_paid >= 50;
    }

    /**
     * Get total savings (convenience method)
     */
    public function getTotalSavingsAttribute()
    {
        return $this->savings ? $this->savings->available_savings : 0;
    }

    /**
     * Check if member can withdraw savings
     * Only allowed if employment has ended
     */
    public function canWithdrawSavings()
    {
        return $this->sacco_status === 'inactive' &&
               $this->sacco_exit_date !== null &&
               $this->exit_reason !== null;
    }

    /**
     * Get withdrawal amount after KES 2,000 retention
     */
    public function getWithdrawalAmountAttribute()
    {
        if (! $this->canWithdrawSavings() || ! $this->savings) {
            return 0;
        }

        $withdrawable = $this->savings->available_savings - 2000;

        return max(0, $withdrawable);
    }

    /**
     * Check if user is a treasurer
     */
    public function isTreasurer()
    {
        return $this->role === 'treasurer';
    }

    /**
     * Get treasurer permissions
     */
    public function getTreasurerPermissionsAttribute()
    {
        if (! $this->isTreasurer() || ! $this->treasurer) {
            return null;
        }

        return [
            'can_issue_cheques' => $this->treasurer->can_issue_cheques,
            'can_approve_expenses' => $this->treasurer->can_approve_expenses,
            'can_process_loans' => $this->treasurer->can_process_loans,
            'signatory_limit' => $this->treasurer->signatory_limit,
            'bank_signatory' => $this->treasurer->bank_signatory,
        ];
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return \Illuminate\Support\Facades\Storage::url($this->profile_photo_path);
        }
        
        return null;
    }

    /**
     * Get national ID image URL
     */
    public function getNationalIdImageUrlAttribute()
    {
        if ($this->national_id_image) {
            return \Illuminate\Support\Facades\Storage::url($this->national_id_image);
        }
        
        return null;
    }

    /**
     * Get phone number (alias for phone field)
     */
    public function getPhoneNumberAttribute()
    {
        return $this->phone;
    }

    /**
     * Set phone number (alias for phone field)
     */
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone'] = $value;
    }

    /**
     * Get active first loan
     */
    public function activeFirstLoan()
    {
        return $this->loans()
            ->where('loan_type', 'first_loan')
            ->whereIn('status', ['active', 'disbursed', 'approved']);
    }

    /**
     * Get active second loan
     */
    public function activeSecondLoan()
    {
        return $this->loans()
            ->where('loan_type', 'second_loan')
            ->whereIn('status', ['active', 'disbursed', 'approved']);
    }

    /**
     * Get all active loans count
     */
    public function getActiveLoansCountAttribute()
    {
        return $this->loans()
            ->whereIn('status', ['active', 'disbursed', 'approved'])
            ->count();
    }

    /**
     * Check if user qualifies for second loan
     */
    public function qualifiesForSecondLoan()
    {
        $firstLoan = $this->activeFirstLoan()->first();
        return $firstLoan && $firstLoan->percentage_paid >= 50;
    }

    /**
     * Check if user can apply for a loan
     */
    public function canApplyForLoan($loanType = 'first_loan')
    {
        if ($loanType === 'first_loan') {
            // For first loan, user must not have any active first loan
            return !$this->activeFirstLoan()->exists();
        } elseif ($loanType === 'second_loan') {
            // For second loan, user must have an active first loan with >= 50% paid
            return $this->qualifiesForSecondLoan() && !$this->activeSecondLoan()->exists();
        }
        
        return false;
    }

    /**
     * Get maximum loan amount user can apply for
     */
    public function getMaxLoanAmount($loanType = 'first_loan')
    {
        $eligibility = $this->getLoanEligibilityAttribute();
        
        if ($loanType === 'second_loan') {
            // For second loan, consider existing loan balances
            $totalActiveLoanBalance = $this->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->whereIn('loan_type', ['first_loan', 'second_loan'])
                ->sum('remaining_balance');
            
            $available = max(0, $eligibility - $totalActiveLoanBalance);
            return max(5000, $available); // Minimum 5,000 for second loan
        }
        
        // For first loan, return the full eligibility
        return $eligibility;
    }

    /**
     * Check document access
     */
    public function canAccessDocument($document)
    {
        // Public documents
        if ($document->is_public) {
            return true;
        }

        // Committee access
        if ($document->access_type === 'committee' && in_array($this->role, $document->allowed_roles)) {
            return true;
        }

        // All members access
        if ($document->access_type === 'members' && in_array('member', $document->allowed_roles) && $this->role === 'member') {
            return true;
        }

        // Specific users access
        if ($document->access_type === 'specific_users' && in_array($this->id, $document->specific_users)) {
            return true;
        }

        return false;
    }

    /**
     * Get formatted monthly salary
     */
    public function getFormattedMonthlySalaryAttribute()
    {
        return 'KES ' . number_format($this->monthly_salary, 2);
    }

    /**
     * Get formatted monthly savings
     */
    public function getFormattedMonthlySavingsAttribute()
    {
        return 'KES ' . number_format($this->monthly_savings, 2);
    }

    /**
     * Get formatted employment date
     */
    public function getFormattedEmploymentDateAttribute()
    {
        return $this->employment_date ? $this->employment_date->format('F d, Y') : 'N/A';
    }

    /**
     * Get formatted date of birth
     */
    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('F d, Y') : 'N/A';
    }

    /**
     * Get age from date of birth
     */
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }

        return $this->date_of_birth->age;
    }
}