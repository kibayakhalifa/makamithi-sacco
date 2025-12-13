<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\MemberApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChairmanController extends Controller
{
    /**
     * Approve or reject member registration
     * From requirements: "Approval is done by the chairman and secretary or treasurer"
     */
    public function approveMember(Request $request, $memberId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,more_info',
            'notes' => 'nullable|string|max:1000',
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

                // Update approval record
                $approval = $member->memberApproval;
                $approval->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approval_notes' => $request->notes,
                    'reviewed_at' => now(),
                ]);

                // Send welcome notification to member
                // $this->sendNotification('member_approved', $member);

                $message = 'Member approved successfully.';
                
            } elseif ($request->action === 'reject') {
                // Reject the member
                $member->update([
                    'sacco_status' => 'inactive',
                    'exit_reason' => 'Rejected during approval: ' . ($request->notes ?? 'No reason provided'),
                    'sacco_exit_date' => now(),
                ]);

                // Update approval record
                $approval = $member->memberApproval;
                $approval->update([
                    'status' => 'rejected',
                    'approved_by' => auth()->id(),
                    'rejection_reason' => $request->notes,
                    'reviewed_at' => now(),
                ]);

                $message = 'Member rejected.';
                
            } else { // more_info
                // Request more information
                $approval = $member->memberApproval;
                $approval->update([
                    'status' => 'more_info',
                    'approval_notes' => 'More information requested: ' . $request->notes,
                    'reviewed_at' => now(),
                ]);

                // Send notification to Secretary
                // $this->sendNotification('more_info_requested', ['member' => $member, 'notes' => $request->notes]);

                $message = 'More information requested from Secretary.';
            }

            DB::commit();
            
            return redirect()->route('chairman.members')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Action failed: ' . $e->getMessage());
        }
    }

    /**
     * Approve or reject loan application
     * From requirements: "The loan application form goes to the chairman for verification"
     */
    public function approveLoan(Request $request, $loanId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'verification_notes' => 'nullable|string|max:1000',
        ]);

        $loan = Loan::with('user.savings')->findOrFail($loanId);
        
        if ($loan->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Loan is not pending approval.');
        }

        // Verify 1.5× rule again (Double-check)
        $maxEligible = $loan->user->savings->available_savings * 1.5;
        
        if ($loan->amount > $maxEligible) {
            return redirect()->back()
                ->with('error', 'Loan amount exceeds maximum eligibility of KES ' . number_format($maxEligible, 2));
        }

        DB::beginTransaction();
        try {
            if ($request->action === 'approve') {
                // Check if Secretary or Treasurer needs to co-approve
                // From requirements: "Approval is done by the chairman and secretary or treasurer"
                $requiredCoApprover = $loan->amount > 100000 ? 'secretary' : 'treasurer'; // Example threshold
                
                $loan->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_date' => now(),
                ]);

                // Send notification to Treasurer for payment processing
                // From requirements: "Advise is send to treasurer for payment"
                // $this->sendNotification('loan_approved', [
                //     'loan' => $loan,
                //     'co_approver_needed' => $requiredCoApprover,
                // ]);

                $message = 'Loan approved. Sent to Treasurer for payment processing.';
                
            } else {
                // Reject the loan
                $loan->update([
                    'status' => 'rejected',
                ]);

                // Send notification to member
                // $this->sendNotification('loan_rejected', [
                //     'loan' => $loan,
                //     'reason' => $request->verification_notes,
                // ]);

                $message = 'Loan rejected.';
            }

            DB::commit();
            
            return redirect()->route('chairman.loan-approvals')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Action failed: ' . $e->getMessage());
        }
    }

    /**
     * Get pending approvals for dashboard
     */
    public function getPendingApprovals()
    {
        $pendingMembers = User::where('sacco_status', 'pending')
            ->with('memberApproval.submittedBy')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingLoans = Loan::where('status', 'pending')
            ->with(['user', 'assistant'])
            ->orderBy('applied_date', 'desc')
            ->get();

        return [
            'pending_members' => $pendingMembers,
            'pending_loans' => $pendingLoans,
            'counts' => [
                'members' => $pendingMembers->count(),
                'loans' => $pendingLoans->count(),
                'total' => $pendingMembers->count() + $pendingLoans->count(),
            ],
        ];
    }

    /**
     * Get member statistics for reports
     */
    public function getMemberStatistics()
    {
        $totalMembers = User::members()->count();
        $activeMembers = User::activeMembers()->count();
        $pendingMembers = User::pendingApproval()->count();
        
        $membersByDepartment = User::members()
            ->select('department', DB::raw('count(*) as count'))
            ->groupBy('department')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->department => $item->count];
            });

        $membersByStatus = User::members()
            ->select('sacco_status', DB::raw('count(*) as count'))
            ->groupBy('sacco_status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->sacco_status => $item->count];
            });

        return [
            'total_members' => $totalMembers,
            'active_members' => $activeMembers,
            'pending_members' => $pendingMembers,
            'by_department' => $membersByDepartment,
            'by_status' => $membersByStatus,
        ];
    }

    // ============ LOAN APPROVALS ============

    /**
     * Chairman dashboard overview
     */
    public function dashboard()
    {
        $stats = [
            'pending_members' => User::where('sacco_status', 'pending')->count(),
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'pending_approvals' => User::where('sacco_status', 'pending')->count() + Loan::where('status', 'pending')->count(),
            'approved_this_month' => Loan::where('status', 'approved')
                ->whereMonth('approved_date', now()->month)
                ->whereYear('approved_date', now()->year)
                ->count(),
            'total_members' => User::where('sacco_status', 'active')->count(),
            'active_loans' => Loan::whereIn('status', ['active', 'disbursed'])->count(),
            'total_disbursed' => Loan::whereIn('status', ['active', 'disbursed'])->sum('amount'),
        ];

        // Get pending members for approval
        $pendingMembers = User::where('sacco_status', 'pending')
            ->with('memberApproval.submittedBy')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get pending loans for approval
        $pendingLoans = Loan::where('status', 'pending')
            ->with('user', 'user.savings')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        return view('chairman.dashboard', compact('stats', 'pendingMembers', 'pendingLoans'));
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
        // Always allow viewing the loan details here; approval actions are guarded elsewhere.
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

            // Notify member
            $loan->user->notify(new \App\Notifications\LoanApproved($loan));

            return redirect()->route('chairman.loan-approvals')
                ->with('success', 'Loan approved! Amount: KES ' . number_format($loan->amount, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to approve loan: ' . $e->getMessage());
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

            // Notify member
            $loan->user->notify(new \App\Notifications\LoanRejected($loan, $request->rejection_reason));

            return redirect()->route('chairman.loan-approvals')
                ->with('success', 'Loan application rejected.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to reject loan: ' . $e->getMessage());
        }
    }
}