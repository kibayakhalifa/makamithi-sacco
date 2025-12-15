<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member');
    }

    /**
     * Display member dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $savings = $user->savings;
        $nextOfKin = $user->nextOfKin;

        // Get active loans
        $activeLoans = $user->loans()
            ->whereIn('status', ['active', 'disbursed'])
            ->get();

        // Get pending loans
        $pendingLoans = $user->loans()
            ->whereIn('status', ['pending', 'under_review'])
            ->get();

        // Get recent transactions
        $recentTransactions = collect(); // Temporary empty collection

        // Calculate statistics
        $stats = [
            'total_savings' => $savings ? $savings->available_savings : 0,
            'active_loans_count' => $activeLoans->count(),
            'total_loan_balance' => $activeLoans->sum('remaining_balance'),
            'withdrawable_amount' => $user->withdrawal_amount,
        ];

        // Get loan payments due this month
        $currentMonth = now()->format('Y-m');
        $duePayments = $activeLoans->flatMap(function ($loan) {
            return $loan->payments()
                ->where('payment_date', '>=', now()->startOfMonth())
                ->where('payment_date', '<=', now()->endOfMonth())
                ->where('status', 'pending')
                ->get();
        });

        return view('member.dashboard', compact(
            'user', 'savings', 'nextOfKin', 'activeLoans',
            'pendingLoans', 'recentTransactions', 'stats', 'duePayments'
        ));
    }

    /**
     * Display member profile
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('nextOfKin', 'savings');

        // Calculate loan eligibility
        $loanEligibility = $user->loan_eligibility;

        // Get account summary
        $accountSummary = [
            'member_since' => $user->sacco_join_date ? $user->sacco_join_date->format('M Y') : 'N/A',
            'total_savings' => $user->savings ? $user->savings->available_savings : 0,
            'active_loans' => $user->loans()->whereIn('status', ['active', 'disbursed'])->sum('amount'),
            'loan_qualification' => $loanEligibility,
            'membership_status' => ucfirst($user->sacco_status),
        ];

        return view('member.profile', compact('user', 'accountSummary', 'loanEligibility'));
    }

    /**
     * Update member profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'national_id' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            'address' => ['required', 'string', 'max:500'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($validator->validated());

        // Update employment info if provided
        if ($request->has('update_employment')) {
            $employmentData = $request->validate([
                'department' => ['nullable', 'string', 'max:100'],
                'position' => ['nullable', 'string', 'max:100'],
                'monthly_salary' => ['nullable', 'numeric', 'min:0'],
                'employment_date' => ['nullable', 'date'],
            ]);

            $user->update($employmentData);
        }

        // Update next of kin if provided
        if ($request->has('update_nok')) {
            $nextOfKinData = $request->validate([
                'next_of_kin_name' => ['nullable', 'string', 'max:255'],
                'next_of_kin_relationship' => ['nullable', 'string', 'max:50'],
                'next_of_kin_phone' => ['nullable', 'string', 'max:20'],
                'next_of_kin_id_number' => ['nullable', 'string', 'max:20'],
                'next_of_kin_address' => ['nullable', 'string', 'max:500'],
            ]);

            // Map form field names to database column names
            $nokUpdateData = [
                'name' => $nextOfKinData['next_of_kin_name'],
                'relationship' => $nextOfKinData['next_of_kin_relationship'],
                'phone' => $nextOfKinData['next_of_kin_phone'],
                'national_id' => $nextOfKinData['next_of_kin_id_number'],
                'address' => $nextOfKinData['next_of_kin_address'],
            ];

            if (! $request->filled(['next_of_kin_name', 'next_of_kin_phone'])) {
                return redirect()->route('member.profile')
                    ->with('success', 'Profile updated successfully!');
            }

            if ($user->nextOfKin) {
                $user->nextOfKin->update($nokUpdateData);
            } else {
                $user->nextOfKin()->create($nokUpdateData);
            }
        }

        return redirect()->route('member.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('member.profile')
            ->with('success', 'Password updated successfully!');
    }
}
