<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChairmanController extends Controller
{
    /**
     * Display chairman members management page with dynamic data
     */
    public function members()
    {
        // Member Statistics
        $totalMembers = User::where('role', 'member')->count();
        $activeMembers = User::where('role', 'member')->where('sacco_status', 'active')->count();
        $pendingMembers = User::where('role', 'member')->where('sacco_status', 'pending')->count();
        $inactiveMembers = User::where('role', 'member')->where('sacco_status', 'inactive')->count();

        // Loan Statistics
        $activeLoans = Loan::whereIn('status', ['active', 'disbursed'])->count();
        $totalLoanAmount = Loan::whereIn('status', ['active', 'disbursed'])->sum('amount');
        $defaultedLoans = Loan::where('status', 'defaulted')->count();

        // Savings Statistics
        $totalSavings = Saving::sum('available_savings');
        $monthlySavingsIncrease = Saving::whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('available_savings');

        // Stats for dashboard
        $stats = [
            'total_members' => $totalMembers,
            'active_members' => $activeMembers,
            'pending_members' => $pendingMembers,
            'inactive_members' => $inactiveMembers,
            'active_loans' => $activeLoans,
            'total_loan_amount' => $totalLoanAmount,
            'defaulted_loans' => $defaultedLoans,
            'total_savings' => $totalSavings,
            'monthly_savings_increase' => $monthlySavingsIncrease,
        ];

        // Pending Members for approval
        $pendingMembersList = User::where('role', 'member')
            ->where('sacco_status', 'pending')
            ->with(['memberApproval' => function ($query) {
                $query->with('submittedBy');
            }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'employee_number' => $member->employee_number,
                    'name' => $member->name,
                    'email' => $member->email,
                    'department' => $member->department,
                    'position' => $member->position,
                    'salary' => $member->salary,
                    'submitted_by' => $member->memberApproval->submittedBy->name ?? 'System',
                    'submitted_date' => $member->created_at,
                    'days_pending' => $member->created_at->diffInDays(now()),
                ];
            });

        // All Members with their savings and loan eligibility
        $allMembers = User::where('role', 'member')
            ->with(['savings'])
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($member) {
                $savings = $member->savings;
                $loanEligibility = $savings ? $savings->available_savings * 1.5 : 0;

                // Determine loan status
                $activeLoan = $member->loans()->whereIn('status', ['active', 'disbursed'])->first();
                $defaultedLoan = $member->loans()->where('status', 'defaulted')->first();
                $completedLoan = $member->loans()->where('status', 'paid')->exists();

                $loanStatus = 'none';
                if ($defaultedLoan) {
                    $loanStatus = 'default';
                } elseif ($activeLoan) {
                    $loanStatus = 'active';
                } elseif ($completedLoan) {
                    $loanStatus = 'completed';
                }

                return [
                    'id' => $member->id,
                    'employee_number' => $member->employee_number,
                    'name' => $member->name,
                    'email' => $member->email,
                    'department' => $member->department,
                    'position' => $member->position,
                    'phone' => $member->phone,
                    'status' => $member->sacco_status,
                    'savings' => $savings ? $savings->available_savings : 0,
                    'loan_eligibility' => $loanEligibility,
                    'date_joined' => $member->created_at->format('Y-m-d'),
                    'loan_status' => $loanStatus,
                ];
            });

        // Department distribution
        $departmentDistribution = User::where('role', 'member')
            ->select('department', DB::raw('count(*) as count'))
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->groupBy('department')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($dept) use ($totalMembers) {
                $percentage = $totalMembers > 0 ? round(($dept->count / $totalMembers) * 100) : 0;

                return [
                    'name' => $dept->department,
                    'count' => $dept->count,
                    'percentage' => $percentage,
                ];
            });

        // Status overview
        $statusOverview = [
            'active_members' => $activeMembers,
            'pending_approval' => $pendingMembers,
            'loan_defaulters' => $defaultedLoans,
            'active_loans' => $activeLoans,
        ];

        return view('chairman.members', compact(
            'stats',
            'pendingMembersList',
            'allMembers',
            'departmentDistribution',
            'statusOverview'
        ));
    }

    /**
     * Approve or reject member registration
     */
    public function approveMember(Request $request, $memberId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:1000',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);

        $member = User::findOrFail($memberId);

        if ($member->sacco_status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Member is not pending approval.');
        }

        DB::beginTransaction();
        try {
            if ($request->action === 'approve') {
                // Approve the member
                $member->update([
                    'sacco_status' => 'active',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                // Create initial savings account if doesn't exist
                if (! $member->savings) {
                    Saving::create([
                        'user_id' => $member->id,
                        'available_savings' => 0,
                        'total_saved' => 0,
                        'total_withdrawn' => 0,
                        'total_interest_earned' => 0,
                    ]);
                }

                // Update approval record if exists
                if ($member->memberApproval) {
                    $member->memberApproval->update([
                        'status' => 'approved',
                        'approved_by' => auth()->id(),
                        'approval_notes' => $request->notes,
                        'reviewed_at' => now(),
                    ]);
                }

                $message = 'Member approved successfully.';

            } else {
                // Reject the member
                $member->update([
                    'sacco_status' => 'inactive',
                    'exit_reason' => $request->rejection_reason,
                    'sacco_exit_date' => now(),
                ]);

                // Update approval record if exists
                if ($member->memberApproval) {
                    $member->memberApproval->update([
                        'status' => 'rejected',
                        'approved_by' => auth()->id(),
                        'rejection_reason' => $request->rejection_reason,
                        'reviewed_at' => now(),
                    ]);
                }

                $message = 'Member rejected.';
            }

            DB::commit();

            return redirect()->route('chairman.members')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Action failed: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get member details for modal
     */
    public function getMemberDetails($memberId)
    {
        $member = User::with(['savings', 'loans' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'nextOfKin'])->findOrFail($memberId);

        $savings = $member->savings;
        $loanEligibility = $savings ? $savings->available_savings * 1.5 : 0;

        // Get active loan if exists
        $activeLoan = $member->loans()
            ->whereIn('status', ['active', 'disbursed'])
            ->first();

        // Check if defaulting
        $defaultedLoan = $member->loans()
            ->where('status', 'defaulted')
            ->exists();

        // Check if completed loan
        $completedLoan = $member->loans()
            ->where('status', 'paid')
            ->exists();

        $loanStatus = 'none';
        $loanStatusText = 'No Active Loan';

        if ($defaultedLoan) {
            $loanStatus = 'default';
            $loanStatusText = 'Defaulting';
        } elseif ($activeLoan) {
            $loanStatus = 'active';
            $loanStatusText = 'Active Loan';
        } elseif ($completedLoan) {
            $loanStatus = 'completed';
            $loanStatusText = 'Loan Completed';
        }

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $member->id,
                'employee_number' => $member->employee_number,
                'name' => $member->name,
                'email' => $member->email,
                'phone' => $member->phone,
                'department' => $member->department,
                'position' => $member->position,
                'salary' => $member->salary,
                'date_joined' => $member->created_at->format('Y-m-d'),
                'status' => $member->sacco_status,
                'savings' => $savings ? $savings->available_savings : 0,
                'loan_eligibility' => $loanEligibility,
                'loan_status' => $loanStatus,
                'loan_status_text' => $loanStatusText,
                'active_loan' => $activeLoan,
            ],
        ]);
    }

    /**
     * Get member statistics for dashboard
     */
    public function getDashboardStats()
    {
        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'pending_members' => User::where('role', 'member')->where('sacco_status', 'pending')->count(),
            'active_loans' => Loan::whereIn('status', ['active', 'disbursed'])->count(),
            'total_loan_amount' => Loan::whereIn('status', ['active', 'disbursed'])->sum('amount'),
            'total_savings' => Saving::sum('available_savings'),
            'monthly_savings_increase' => Saving::whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->sum('available_savings'),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }

    /**
     * Get filtered members
     */
    public function getFilteredMembers(Request $request)
    {
        $query = User::where('role', 'member');

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('employee_number', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Department filter
        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('sacco_status', $request->status);
        }

        $members = $query->with(['savings'])
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($member) {
                $savings = $member->savings;
                $loanEligibility = $savings ? $savings->available_savings * 1.5 : 0;

                // Determine loan status
                $activeLoan = $member->loans()->whereIn('status', ['active', 'disbursed'])->first();
                $defaultedLoan = $member->loans()->where('status', 'defaulted')->first();

                $loanStatus = 'none';
                if ($defaultedLoan) {
                    $loanStatus = 'default';
                } elseif ($activeLoan) {
                    $loanStatus = 'active';
                } elseif ($member->loans()->where('status', 'paid')->exists()) {
                    $loanStatus = 'completed';
                }

                return [
                    'id' => $member->id,
                    'employee_number' => $member->employee_number,
                    'name' => $member->name,
                    'email' => $member->email,
                    'department' => $member->department,
                    'position' => $member->position,
                    'phone' => $member->phone,
                    'status' => $member->sacco_status,
                    'savings' => $savings ? $savings->available_savings : 0,
                    'loan_eligibility' => $loanEligibility,
                    'date_joined' => $member->created_at->format('Y-m-d'),
                    'loan_status' => $loanStatus,
                ];
            });

        return response()->json([
            'success' => true,
            'members' => $members,
            'count' => $members->count(),
        ]);
    }

        /**
     * Dashboard statistics
     */
    public function dashboard()
    {
        // Get all stats
        $totalMembers = User::where('role', 'member')->count();
        $pendingMembers = User::where('role', 'member')->where('sacco_status', 'pending')->count();
        $activeLoans = Loan::whereIn('status', ['active', 'disbursed'])->count();
        $totalLoanAmount = Loan::whereIn('status', ['active', 'disbursed'])->sum('amount');
        $totalSavings = Saving::sum('available_savings');
        $monthlySavingsIncrease = Saving::whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('available_savings');

        $approvedThisMonth = Loan::where('status', 'approved')
            ->whereMonth('approved_date', now()->month)
            ->whereYear('approved_date', now()->year)
            ->count();

        $stats = [
            'total_members' => $totalMembers,
            'pending_approvals' => $pendingMembers,
            'pending_members' => $pendingMembers,
            'approved_this_month' => $approvedThisMonth,
            'active_loans' => $activeLoans,
            'total_loan_amount' => $totalLoanAmount,
            'total_savings' => $totalSavings,
            'monthly_savings_increase' => $monthlySavingsIncrease,
        ];

        // Get pending members for approval (limit 5)
        $pendingMembersList = User::where('role', 'member')
            ->where('sacco_status', 'pending')
            ->with(['memberApproval' => function ($query) {
                $query->with('submittedBy');
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get pending loans for approval (limit 5)
        $pendingLoans = Loan::where('status', 'pending')
            ->with(['user', 'user.savings'])
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // Get recent activities
        $recentActivities = [];

        try {
            // 1. Get recent loan approvals (last 7 days)
            $recentLoanApprovals = Loan::where('status', 'approved')
                ->where('approved_date', '>=', now()->subDays(7))
                ->with('user')
                ->orderBy('approved_date', 'desc')
                ->take(2)
                ->get()
                ->map(function($loan) {
                    return [
                        'type' => 'loan_approved',
                        'icon' => '✔️',
                        'title' => 'Loan Approved',
                        'member' => $loan->user->name ?? 'Unknown Member',
                        'amount' => $loan->amount,
                        'time' => $loan->approved_date ?? $loan->updated_at,
                        'link' => route('chairman.loans.approve-view', $loan->id),
                    ];
                })->toArray();

            // 2. Get recent member approvals (last 7 days)
            $recentMemberApprovals = User::where('sacco_status', 'active')
                ->where('approved_at', '>=', now()->subDays(7))
                ->whereNotNull('approved_at')
                ->orderBy('approved_at', 'desc')
                ->take(2)
                ->get()
                ->map(function($member) {
                    return [
                        'type' => 'member_approved',
                        'icon' => '👥',
                        'title' => 'Member Registration Approved',
                        'member' => $member->name ?? 'Unknown',
                        'amount' => null,
                        'time' => $member->approved_at,
                        'link' => route('chairman.members'),
                    ];
                })->toArray();

            // 3. Get recent loan applications (last 7 days)
            $recentLoanApplications = Loan::where('status', 'pending')
                ->where('created_at', '>=', now()->subDays(7))
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get()
                ->map(function($loan) {
                    return [
                        'type' => 'loan_applied',
                        'icon' => '📝',
                        'title' => 'New Loan Application',
                        'member' => $loan->user->name ?? 'Unknown Member',
                        'amount' => $loan->amount,
                        'time' => $loan->created_at,
                        'link' => route('chairman.loans.approve-view', $loan->id),
                    ];
                })->toArray();

            // 4. Get recent member registrations (last 7 days)
            $recentMemberRegistrations = User::where('sacco_status', 'pending')
                ->where('created_at', '>=', now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get()
                ->map(function($member) {
                    return [
                        'type' => 'member_applied',
                        'icon' => '📋',
                        'title' => 'New Member Registration',
                        'member' => $member->name ?? 'Unknown',
                        'amount' => null,
                        'time' => $member->created_at,
                        'link' => route('chairman.members'),
                    ];
                })->toArray();

            // Merge all activities into a single array
            $allActivities = array_merge(
                $recentLoanApprovals,
                $recentMemberApprovals,
                $recentLoanApplications,
                $recentMemberRegistrations
            );

            // Sort by time (newest first)
            usort($allActivities, function($a, $b) {
                return strtotime($b['time']) - strtotime($a['time']);
            });

            // Take only 6 most recent
            $recentActivities = array_slice($allActivities, 0, 6);

            // Convert to collection for easier handling in blade
            $recentActivities = collect($recentActivities)->map(function($activity) {
                // Convert time strings to Carbon instances
                $activity['time'] = \Carbon\Carbon::parse($activity['time']);
                return (object) $activity; // Convert to object for easier access
            });

        } catch (\Exception $e) {
            \Log::error('Error loading recent activities: ' . $e->getMessage());
            // Fallback to empty collection
            $recentActivities = collect();
        }

        // IMPORTANT: Return the view with all data
        return view('chairman.dashboard', compact(
            'stats',
            'pendingMembersList',
            'pendingLoans',
            'recentActivities'
        ));
    }
    /**
     * Show loan approvals dashboard
     */
    public function loanApprovals()
    {
        $stats = [
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'approved_today' => Loan::where('status', 'approved')
                ->whereDate('approved_date', today())
                ->count(),
            'total_approved' => Loan::where('status', 'approved')->count(),
            'total_disbursed' => Loan::whereIn('status', ['active', 'disbursed'])->sum('amount'),
        ];

        $pendingLoans = Loan::where('status', 'pending')
            ->with('user', 'user.savings')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        $recentlyProcessed = Loan::whereIn('status', ['approved', 'rejected'])
            ->with('user')
            ->orderBy('approved_date', 'desc')
            ->limit(5)
            ->get();

        return view('chairman.loan-approvals', compact('stats', 'pendingLoans', 'recentlyProcessed'));
    }

    /**
     * Show individual loan for approval
     */
    public function viewLoanForApproval(Loan $loan)
    {
        $loan->load(['user', 'user.savings', 'user.nextOfKin', 'payments', 'approver', 'disburser']);

        return view('chairman.loan-approval-detail', compact('loan'));
    }

    /**
     * Approve a loan application
     */
    public function approveLoanApplication(Request $request, Loan $loan)
    {
        $request->validate([
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'This loan has already been processed.');
        }

        DB::beginTransaction();

        try {
            $loan->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_date' => now(),
            ]);

            DB::commit();

            return redirect()->route('chairman.loan-approvals')
                ->with('success', 'Loan approved! Amount: KES '.number_format($loan->amount, 2));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to approve loan: '.$e->getMessage());
        }
    }

    /**
     * Reject a loan application
     */
    public function rejectLoanApplication(Request $request, Loan $loan)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'This loan has already been processed.');
        }

        DB::beginTransaction();

        try {
            $loan->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_date' => now(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            DB::commit();

            return redirect()->route('chairman.loan-approvals')
                ->with('success', 'Loan application rejected.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to reject loan: '.$e->getMessage());
        }
    }
}
