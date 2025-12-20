<?php

namespace App\Http\Controllers;

use App\Models\ChequeRecord;
use App\Models\Loan;
use App\Models\MemberApproval;
use App\Models\NextOfKin;
use App\Models\Saving;
use App\Models\Savings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SecretaryController extends Controller
{
    /**
 * Secretary Dashboard
 */
public function dashboard()
{
    // Total members count
    $totalMembers = User::where('role', 'member')->count();
    
    // New members this month
    $newThisMonth = User::where('role', 'member')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();
    
    // Total savings
    $totalSavings = \App\Models\Saving::sum('total_savings') ?? 0;
    
    // Savings growth (placeholder - you can implement actual growth calculation)
    $previousMonthSavings = \App\Models\Saving::whereMonth('last_updated', now()->subMonth()->month)
        ->sum('total_savings') ?? 0;
    $savingsGrowth = $previousMonthSavings > 0 ? 
        (($totalSavings - $previousMonthSavings) / $previousMonthSavings) * 100 : 0;
    
    // Active loans
    $activeLoans = \App\Models\Loan::whereIn('status', ['active', 'disbursed'])->get();
    $totalActiveLoans = $activeLoans->sum('amount') ?? 0;
    $activeLoansCount = $activeLoans->count();
    
    // Pending members
    $pendingMembers = User::where('role', 'member')
        ->where('sacco_status', 'pending')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    $pendingMembersCount = User::where('role', 'member')
        ->where('sacco_status', 'pending')
        ->count();
    
    // Pending loans
    $pendingLoans = \App\Models\Loan::where('status', 'pending')->count();
    
    // Recent assisted loans
    $recentLoans = \App\Models\Loan::with('user')
        ->where('application_type', 'assisted')
        ->orWhere('assisted_by', auth()->id())
        ->orderBy('applied_date', 'desc')
        ->limit(5)
        ->get();
    
    // Overdue loans (placeholder - implement based on your payment schedule)
    $overdueLoans = \App\Models\Loan::where('status', 'active')
        ->where('next_payment_date', '<', now())
        ->count();
    
    // Upcoming meetings (you can create a meetings table or use config/array)
    $upcomingMeetings = [
        [
            'title' => 'Monthly SACCO Meeting',
            'date' => now()->addDays(3)->format('Y-m-d'),
            'time' => '2:00 PM',
            'venue' => 'Board Room',
            'description' => 'Monthly SACCO review meeting'
        ],
        [
            'title' => 'Loan Committee Meeting',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '10:00 AM',
            'venue' => 'Conference Room A',
            'description' => 'Review of pending loan applications'
        ],
        [
            'title' => 'AGM Preparation',
            'date' => now()->addDays(14)->format('Y-m-d'),
            'time' => '3:00 PM',
            'venue' => 'Main Hall',
            'description' => 'Annual General Meeting preparation'
        ]
    ];
    
    $stats = [
        'total_members' => $totalMembers,
        'new_this_month' => $newThisMonth,
        'total_savings' => $totalSavings,
        'savings_growth_percentage' => round($savingsGrowth, 1),
        'total_active_loans' => $totalActiveLoans,
        'active_loans_count' => $activeLoansCount,
        'pending_approvals' => $pendingMembersCount + $pendingLoans,
        'pending_members' => $pendingMembersCount,
        'pending_loans' => $pendingLoans,
        'overdue_loans' => $overdueLoans,
        'pending_documents' => 0, // Implement if you have document management
    ];
    
    return view('secretary.dashboard', compact(
        'stats',
        'pendingMembers',
        'recentLoans',
        'upcomingMeetings'
    ));
}
    /**
     * Store new member registration (From requirements: "When an employee joins the Company, they are registered into the sacco")
     */
    /**
 * Store new member registration
 */

    /**
 * Display all members with real data
 */
public function members()
    {
        $members = User::where('role', 'member')
            ->with(['savings', 'nextOfKin'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Calculate stats from database
        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'active_members' => User::where('role', 'member')->where('sacco_status', 'active')->count(),
            'pending_members' => User::where('role', 'member')->where('sacco_status', 'pending')->count(),
            'rejected_members' => User::where('role', 'member')->where('sacco_status', 'rejected')->count(),
            'new_this_month' => User::where('role', 'member')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('secretary.members', compact('members', 'stats'));
    }

    /**
     * Show form to create a new member
     */
    public function createMember()
    {
        return view('secretary.members.create');
    }

    /**
     * Store new member registration
     */
    public function storeMember(Request $request)
    {
        \Log::info('Member registration attempt:', $request->all());

        try {
            // Validate the data - Make next of kin optional
            $validated = $request->validate([
                'employee_number' => 'required|unique:users,employee_number',
                'national_id' => 'required|unique:users,national_id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'department' => 'required|string',
                'position' => 'required|string',
                'employment_date' => 'required|date',
                'monthly_salary' => 'required|numeric|min:0',
                'monthly_savings' => 'required|numeric|min:0',
                'initial_topup' => 'nullable|numeric|min:0',
                'next_of_kin_name' => 'nullable|string',
                'next_of_kin_relationship' => 'nullable|string|in:Spouse,Parent,Sibling,Child,Other,spouse,parent,sibling,child,other',
                'next_of_kin_phone' => 'nullable|string',
                'next_of_kin_id' => 'nullable|string',
            ]);

            \Log::info('Validation passed for member:', ['email' => $validated['email']]);

            DB::beginTransaction();

            // Create User - Use exact field names from User model
            $user = new User;
            $user->employee_number = $validated['employee_number'];
            $user->national_id = $validated['national_id'];
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->date_of_birth = $validated['date_of_birth'];
            $user->department = $validated['department'];
            $user->position = $validated['position'];
            $user->employment_date = $validated['employment_date'];
            $user->monthly_salary = $validated['monthly_salary'];
            $user->monthly_savings = $validated['monthly_savings'];
            $user->password = Hash::make($validated['national_id']);
            $user->role = 'member';
            $user->sacco_status = 'pending';
            $user->sacco_join_date = now();
            $user->created_at = now();
            $user->save();

            \Log::info('User created with ID:', ['id' => $user->id]);

            // Create Next of Kin (OPTIONAL)
            if (!empty($validated['next_of_kin_name'])) {
                NextOfKin::create([
                    'user_id' => $user->id,
                    'name' => $validated['next_of_kin_name'],
                    'relationship' => $validated['next_of_kin_relationship'] ?? 'Other',
                    'phone' => $validated['next_of_kin_phone'],
                    'national_id' => $validated['next_of_kin_id'] ?? null,
                ]);
                \Log::info('Next of kin created');
            }

            // Create Savings Record - Account starts at zero unless initial topup
            $initialBalance = $validated['initial_topup'] ?? 0;
            
            Saving::create([
                'user_id' => $user->id,
                'payroll_savings' => $validated['monthly_savings'],
                'voluntary_savings' => 0,
                'interest_earned' => 0,
                'total_savings' => $initialBalance,
                'withdrawn_savings' => 0,
                'available_savings' => $initialBalance,
                'loan_eligibility' => $initialBalance * 1.5,
                'last_updated' => now(),
            ]);

            \Log::info('Savings record created');

            // Create Member Approval
            MemberApproval::create([
                'user_id' => $user->id,
                'submitted_by' => auth()->id(),
                'status' => 'pending',
                'submission_notes' => 'New employee registration',
                'submitted_at' => now(),
            ]);

            \Log::info('Member approval record created');

            DB::commit();

            \Log::info('Member registration COMPLETED for:', ['email' => $user->email]);

            return redirect()->route('secretary.members')
                ->with('success', 'Member registered successfully! Sent to Chairman for approval.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Member registration failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to register member: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show member details
     */
    public function showMember(User $user)
    {
        if ($user->role !== 'member') {
            abort(403, 'Not a member');
        }
        
        $user->load(['savings', 'nextOfKin', 'loans', 'memberApproval']);
        return view('secretary.members.show', compact('user'));
    }

    /**
     * Show form to edit member
     */
    public function editMember(User $user)
    {
        if ($user->role !== 'member') {
            abort(403, 'Not a member');
        }
        
        return view('secretary.members.edit', compact('user'));
    }

    /**
     * Update member
     */
    public function updateMember(Request $request, User $user)
    {
        if ($user->role !== 'member') {
            abort(403, 'Not a member');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'department' => 'required|string',
            'position' => 'required|string',
            'monthly_salary' => 'required|numeric|min:0',
            'monthly_savings' => 'required|numeric|min:0',
        ]);

        $user->update($validated);

        return redirect()->route('secretary.members')
            ->with('success', 'Member updated successfully!');
    }

    /**
     * Delete member
     */
    public function destroyMember(User $user)
    {
        if ($user->role !== 'member') {
            abort(403, 'Not a member');
        }
        
        $user->delete();

        return redirect()->route('secretary.members')
            ->with('success', 'Member deleted successfully!');
    }

    /**
     * Approve a member
     */
    public function approveMember(User $user)
    {
        if ($user->role !== 'member') {
            abort(403, 'Not a member');
        }
        
        $user->update([
            'sacco_status' => 'active',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        if ($user->memberApproval) {
            $user->memberApproval->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'approval_notes' => 'Approved by secretary',
            ]);
        }

        return redirect()->route('secretary.members')
            ->with('success', 'Member approved successfully!');
    }

    /**
     * Reject a member
     */
    public function rejectMember(Request $request, User $user)
    {
        if ($user->role !== 'member') {
            abort(403, 'Not a member');
        }
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $user->update([
            'sacco_status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        if ($user->memberApproval) {
            $user->memberApproval->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);
        }

        return redirect()->route('secretary.members')
            ->with('success', 'Member rejected successfully!');
    }

    /**
     * Assist with loan application (For illiterate members)
     * From requirements: "A member fills in loan application form"
     */
    public function storeAssistedLoan(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
            'period_months' => 'required|integer|min:1|max:60',
            'purpose' => 'required|string|max:500',
        ]);

        // Get member and their savings
        $member = User::with('savings')->findOrFail($validated['member_id']);

        if (! $member->savings) {
            return redirect()->back()
                ->with('error', 'Member has no savings record.')
                ->withInput();
        }

        // Check 1.5× rule (From requirements: "Loans are issued at a rate of 1.5 of your savings")
        $maxEligible = $member->savings->available_savings * 1.5;

        if ($validated['amount'] > $maxEligible) {
            return redirect()->back()
                ->with('error', 'Loan amount exceeds maximum eligibility of KES '.number_format($maxEligible, 2))
                ->withInput();
        }

        // Check for active loans if applying for top-up
        $loanType = $request->loan_type ?? 'normal';

        if ($loanType === 'topup') {
            $activeLoan = $member->activeLoan;

            if (! $activeLoan) {
                return redirect()->back()
                    ->with('error', 'Member has no active loan for top-up.')
                    ->withInput();
            }

            // Check 50% repayment rule (From requirements: "paid upto 50% will be eligible for top up loans")
            if (! $activeLoan->qualifiesForTopUp()) {
                return redirect()->back()
                    ->with('error', 'Member must have paid at least 50% of current loan for top-up eligibility.')
                    ->withInput();
            }

            // Check total loans don't exceed 1.5× savings
            $totalLoans = $member->loans()->whereIn('status', ['active', 'disbursed'])->sum('remaining_balance');
            if (($totalLoans + $validated['amount']) > $maxEligible) {
                return redirect()->back()
                    ->with('error', 'Total loans would exceed 1.5× savings limit.')
                    ->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // Calculate loan details (From requirements: 5% fixed interest calculation)
            $loanDetails = Loan::calculateLoanDetails($validated['amount'], $validated['period_months']);

            $loan = Loan::create([
                'user_id' => $validated['member_id'],
                'loan_number' => Loan::generateLoanNumber(),
                'loan_type' => $loanType,
                'amount' => $validated['amount'],
                'interest_rate' => $loanDetails['interest_rate'],
                'interest_amount' => $loanDetails['interest_amount'],
                'total_repayable' => $loanDetails['total_repayable'],
                'period_months' => $validated['period_months'],
                'monthly_payment' => $loanDetails['monthly_payment'],
                'remaining_balance' => $loanDetails['total_repayable'],
                'months_remaining' => $validated['period_months'],
                'purpose' => $validated['purpose'],
                'application_type' => 'assisted',
                'assisted_by' => auth()->id(),
                'status' => 'pending',
                'applied_date' => now(),
            ]);

            DB::commit();

            // Send notification to Chairman (From requirements: "goes to the chairman for verification")
            // $this->sendNotification('new_loan_pending', $loan);

            return redirect()->route('secretary.dashboard')
                ->with('success', 'Loan application submitted successfully! Sent to Chairman for verification.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to submit loan application: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Process savings withdrawal request
     * From requirements: "A member can only withdraw savings if they cease to be an employee"
     */
    public function processWithdrawalRequest(Request $request, $memberId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|in:resignation,termination,death,other',
        ]);

        $member = User::with('savings')->findOrFail($memberId);

        // Check employment status (From requirements)
        if ($member->sacco_status !== 'inactive') {
            return redirect()->back()
                ->with('error', 'Member must have ceased employment to withdraw savings.');
        }

        DB::beginTransaction();
        try {
            // Process withdrawal with KES 2,000 retention
            $withdrawalResult = $member->savings->processWithdrawal($request->amount);

            // Record withdrawal transaction
            $transaction = $member->savingsTransactions()->create([
                'transaction_ref' => 'WD-'.date('Ymd').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'balance_before' => $withdrawalResult['new_balance'] + $request->amount + 2000, // Include retained amount
                'balance_after' => $withdrawalResult['new_balance'],
                'status' => 'pending', // Will be completed when cheque is issued
                'description' => 'Savings withdrawal - '.$request->reason,
                'transaction_date' => now(),
                'posted_by' => auth()->id(),
                'notes' => 'KES 2,000 retained by SACCO as per policy',
            ]);

            // Create cheque record (From requirements: "Upon withdraw of savings a cheque is issued")
            $cheque = ChequeRecord::create([
                'savings_withdrawal_id' => $transaction->id,
                'user_id' => $memberId,
                'cheque_number' => $this->generateChequeNumber(),
                'bank_name' => 'Makamithi Sacco Bank',
                'bank_branch' => 'Main Branch',
                'account_number' => $member->employee_number, // Using employee number as account reference
                'amount' => $request->amount,
                'purpose' => 'savings_withdrawal',
                'status' => 'issued',
                'issue_date' => now(),
                'issued_by' => auth()->id(),
                'issue_notes' => "Savings withdrawal for {$member->name}. KES 2,000 retained.",
            ]);

            // Send notification to Treasurer for cheque issuance
            // From requirements: "Issuing of the cheque and recording of the same is done by the treasurer"
            // $this->sendNotification('cheque_ready', $cheque);

            DB::commit();

            return redirect()->route('secretary.dashboard')
                ->with('success', 'Withdrawal request processed. Cheque number '.$cheque->cheque_number.' issued to Treasurer.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Withdrawal failed: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Generate unique cheque number
     */
    private function generateChequeNumber()
    {
        $date = date('Ymd');
        $lastCheque = ChequeRecord::where('cheque_number', 'like', "CHQ-{$date}-%")
            ->orderBy('cheque_number', 'desc')
            ->first();

        $sequence = $lastCheque ? (int) substr($lastCheque->cheque_number, -4) + 1 : 1;

        return "CHQ-{$date}-".str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * View pending loans for secretary approval
     */
    public function loanApprovals()
    {
        $loans = Loan::where('status', 'pending')
            ->with('user')
            ->orderBy('applied_date', 'desc')
            ->paginate(10);

        return view('secretary.loan-approvals', compact('loans'));
    }
    /**
 * Show loan assistance page
 */
public function loanAssist()
{
    // Get all active members who can apply for loans
    $members = User::where('role', 'member')
        ->where('sacco_status', 'active')
        ->with(['savings' => function($query) {
            $query->select('user_id', 'available_savings', 'loan_eligibility');
        }])
        ->orderBy('name')
        ->get(['id', 'employee_number', 'name', 'email', 'department', 'position']);
    
    return view('secretary.loan-assist', compact('members'));
}



    /**
     * Show loan approval detail page
     */
    public function loanApprovalDetail(Loan $loan)
    {
        // Allow secretary to view processed loans as well (history view)
        $loan->load(['user', 'approver', 'disburser', 'payments']);

        return view('secretary.loan-approval-detail', compact('loan'));
    }

    /**
     * Approve a loan application (Secretary level)
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

            return redirect()->route('secretary.loan-approvals')
                ->with('success', 'Loan approved! Amount: KES '.number_format($loan->amount, 2));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to approve loan: '.$e->getMessage());
        }
    }

    /**
     * Reject a loan application (Secretary level)
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

            return redirect()->route('secretary.loan-approvals')
                ->with('success', 'Loan application rejected.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to reject loan: '.$e->getMessage());
        }
    }

    /**
     * View loan history (all loans with different statuses)
     */
    public function loanHistory()
    {
        $loans = Loan::with('user', 'approver', 'disburser')
            ->orderBy('applied_date', 'desc')
            ->paginate(15);

        $loanStats = [
            'total_loans' => Loan::count(),
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'approved_loans' => Loan::where('status', 'approved')->count(),
            'active_loans' => Loan::whereIn('status', ['active', 'disbursed'])->count(),
            'rejected_loans' => Loan::where('status', 'rejected')->count(),
            'completed_loans' => Loan::where('status', 'completed')->count(),
            'total_amount' => Loan::sum('amount'),
            'total_disbursed' => Loan::whereIn('status', ['active', 'disbursed', 'completed'])->sum('amount'),
        ];

        $loansByStatus = [
            'pending' => Loan::where('status', 'pending')->count(),
            'approved' => Loan::where('status', 'approved')->count(),
            'active' => Loan::whereIn('status', ['active', 'disbursed'])->count(),
            'rejected' => Loan::where('status', 'rejected')->count(),
            'completed' => Loan::where('status', 'completed')->count(),
        ];

        return view('secretary.loan-history', compact('loans', 'loanStats', 'loansByStatus'));
    }

    /**
     * Send notifications (SMS/Email)
     * From requirements: "Notifications" section
     */
    private function sendNotification($type, $data)
    {
        // This would integrate with SMS gateway and email service
        // For now, we'll log it

        \Log::info('Notification sent', [
            'type' => $type,
            'data' => $data,
            'sent_at' => now(),
        ]);

        return true;
    }
}
