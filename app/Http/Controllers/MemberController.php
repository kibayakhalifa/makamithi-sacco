<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SavingsTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member')->except(['resendCredentials']);
    }

    /**
     * Display member dashboard
     */

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

        // Get recent transactions - FIXED: Check if savings exists first
        $recentTransactions = collect();

        if ($savings) {
            $recentTransactions = SavingsTransaction::where('user_id', $user->id)
                ->orderBy('transaction_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        // Calculate statistics - FIXED
        $stats = [
            'total_savings' => $savings ? $savings->available_savings : 0,
            'active_loans_count' => $activeLoans->count(),
            'total_loan_balance' => $activeLoans->sum('remaining_balance'),
            'withdrawable_amount' => $this->calculateWithdrawableAmount($user),
            'loan_eligibility' => $savings ? min($savings->available_savings * 1.5, 1000000) : 0, // Cap at 1M
        ];

        // Get loan payments due this month
        $duePayments = $activeLoans->flatMap(function ($loan) {
            return $loan->payments()
                ->where('status', 'pending')
                ->whereDate('payment_date', '<=', now()->addDays(7)) // Payments due in next 7 days
                ->get();
        });

        return view('member.dashboard', compact(
            'user',
            'savings',
            'nextOfKin',
            'activeLoans',
            'pendingLoans',
            'recentTransactions',
            'stats',
            'duePayments'
        ));
    }

    /**
     * Calculate withdrawable amount
     */
    private function calculateWithdrawableAmount($user)
    {
        $savings = $user->savings;

        if (!$savings) {
            return 0;
        }

        // If user is active, they cannot withdraw - only eligible for loans
        if ($user->sacco_status === 'active') {
            return 0; // Active members cannot withdraw
        }

        // For inactive/exited members, they can withdraw savings minus KES 2,000 retention
        $withdrawable = $savings->available_savings - 2000;

        return max(0, $withdrawable); // Ensure not negative
    }

    /**
     * Display member profile
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('nextOfKin', 'savings');

        // Calculate loan eligibility
        $savings = $user->savings;
        $loanEligibility = $savings ? $savings->available_savings * 1.5 : 0;

        // Get account summary
        $accountSummary = [
            'member_since' => $user->sacco_join_date ? $user->sacco_join_date->format('M Y') : 'N/A',
            'total_savings' => $savings ? $savings->available_savings : 0,
            'active_loans' => $user->loans()->whereIn('status', ['active', 'disbursed'])->sum('amount'),
            'active_loans_count' => $user->loans()->whereIn('status', ['active', 'disbursed'])->count(),
            'loan_qualification' => $loanEligibility,
            'membership_status' => ucfirst($user->sacco_status),
            'monthly_contributions' => $user->monthly_savings ?? 0,
            'annual_contributions' => ($user->monthly_savings ?? 0) * 12,
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
                'monthly_savings' => ['nullable', 'numeric', 'min:0', 'max:' . ($request->monthly_salary ?? $user->monthly_salary)],
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

            if (!$request->filled(['next_of_kin_name', 'next_of_kin_phone'])) {
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
    public function resendCredentials(User $user)
    {
        // Authorization check
        $allowedRoles = ['secretary', 'admin', 'chairman', 'treasurer'];
        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        // Check if user is pending
        if ($user->sacco_status === 'pending') {
            return back()->with('error', 'Cannot resend credentials for pending members. Approve the member first.');
        }

        try {
            // Generate a temporary password (8-10 characters with letters and numbers)
            $temporaryPassword = Str::random(10);

            // Update user's password
            $user->password = Hash::make($temporaryPassword);
            $user->save();

            // Log the action with the password (for testing/audit trail)
            Log::info('New credentials generated for user:', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'employee_number' => $user->employee_number,
                'temporary_password' => $temporaryPassword, // Logged for testing
                'password_hashed' => 'YES',
                'timestamp' => now()->toDateTimeString(),
                'action_by' => auth()->user()->name . ' (ID: ' . auth()->user()->id . ')',
                'action_by_role' => auth()->user()->role,
                'note' => 'User should change password on first login'
            ]);

            // TODO: Uncomment this when you have email setup
            // Send email to user with credentials
            // Mail::to($user->email)->send(new CredentialsEmail($user, $temporaryPassword));

            // For now, show the password to the secretary
            return back()->with([
                'success' => 'Credentials reset successfully!',
                'password_info' => [
                    'user' => $user->name,
                    'email' => $user->email,
                    'employee_number' => $user->employee_number,
                    'temporary_password' => $temporaryPassword,
                    'message' => 'Share this password with the member. They should change it on first login.'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to reset credentials for user ' . $user->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to reset credentials: ' . $e->getMessage());
        }
    }
}