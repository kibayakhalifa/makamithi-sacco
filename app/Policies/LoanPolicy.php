<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the loan.
     */
    public function view(User $user, Loan $loan): bool
    {
        // Member can view their own loans
        if ($user->id === $loan->user_id) {
            return true;
        }

        // Chairman, Secretary, Treasurer and Admin roles can view loans
        if (in_array($user->role, ['chairman', 'secretary', 'treasurer', 'admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can approve the loan.
     */
    public function approve(User $user, Loan $loan): bool
    {
        // Chairman and secretary can approve (depending on business rules)
        return in_array($user->role, ['chairman', 'secretary']);
    }

    /**
     * Determine whether the user can reject the loan.
     */
    public function reject(User $user, Loan $loan): bool
    {
        return in_array($user->role, ['chairman', 'secretary']);
    }

    /**
     * Determine whether the treasurer can disburse the loan.
     */
    public function disburse(User $user, Loan $loan): bool
    {
        return $user->role === 'treasurer' && $loan->status === 'approved';
    }
}
