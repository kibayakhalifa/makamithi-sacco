<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\Savings;
use App\Models\NextOfKin;
use App\Models\MemberApproval;
use App\Models\ChequeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SecretaryController extends Controller
{
    /**
     * Store new member registration (From requirements: "When an employee joins the Company, they are registered into the sacco")
     */
    public function storeMember(Request $request)
    {
        $validated = $request->validate([
            // Personal Information
            'employee_number' => 'required|unique:users,employee_number',
            'national_id' => 'required|unique:users,national_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            
            // Employment Details (From requirements: "employment details form the bio data")
            'department' => 'required|string',
            'position' => 'required|string',
            'employment_date' => 'required|date',
            'monthly_salary' => 'required|numeric|min:0',
            
            // Savings Setup (From requirements: "predetermined amount for savings")
            'monthly_savings' => 'required|numeric|min:0',
            'initial_topup' => 'nullable|numeric|min:0',
            
            // Next of Kin (From requirements: "Provision for capturing the next of kin")
            'next_of_kin_name' => 'required|string',
            'next_of_kin_relationship' => 'required|string|in:spouse,parent,sibling,child,other',
            'next_of_kin_phone' => 'required|string',
            'next_of_kin_id' => 'nullable|string',
            'next_of_kin_address' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create user with pending status (Requires Chairman approval)
            $user = User::create([
                'employee_number' => $validated['employee_number'], // Member number = Employee number
                'national_id' => $validated['national_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'],
                'department' => $validated['department'],
                'position' => $validated['position'],
                'employment_date' => $validated['employment_date'],
                'monthly_salary' => $validated['monthly_salary'],
                'monthly_savings' => $validated['monthly_savings'], // Predetermined savings amount
                'password' => Hash::make($validated['employee_number']), // Default password = employee number
                'role' => 'member',
                'sacco_status' => 'pending', // Requires Chairman approval
                'sacco_join_date' => now(),
            ]);

            // Create next of kin record (For death benefits)
            $user->nextOfKin()->create([
                'name' => $validated['next_of_kin_name'],
                'relationship' => $validated['next_of_kin_relationship'],
                'phone' => $validated['next_of_kin_phone'],
                'national_id' => $validated['next_of_kin_id'],
                'address' => $validated['next_of_kin_address'],
            ]);

            // Create initial savings record
            $savings = Savings::createForNewMember($user, $validated['monthly_savings']);
            
            // Add initial top-up if provided
            if ($request->filled('initial_topup') && $request->initial_topup > 0) {
                $savings->addVoluntarySavings($request->initial_topup);
                
                // Record the transaction
                $user->savingsTransactions()->create([
                    'transaction_ref' => 'TOPUP-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'type' => 'voluntary_deposit',
                    'amount' => $request->initial_topup,
                    'balance_before' => $validated['monthly_savings'],
                    'balance_after' => $validated['monthly_savings'] + $request->initial_topup,
                    'status' => 'completed',
                    'description' => 'Initial top-up savings',
                    'payment_method' => 'bank_transfer',
                    'transaction_date' => now(),
                    'posted_date' => now(),
                    'posted_by' => auth()->id(),
                ]);
            }

            // Create approval record for Chairman
            MemberApproval::create([
                'user_id' => $user->id,
                'submitted_by' => auth()->id(),
                'status' => 'pending',
                'submission_notes' => 'New employee registration',
                'submitted_at' => now(),
            ]);

            DB::commit();

            // Send notification to Chairman (From requirements: "Notifications")
            // This would integrate with SMS/email service
            // $this->sendNotification('new_member_pending', $user);

            return redirect()->route('secretary.members')
                ->with('success', 'Member registered successfully! Sent to Chairman for approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to register member: ' . $e->getMessage())
                ->withInput();
        }
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
        
        if (!$member->savings) {
            return redirect()->back()
                ->with('error', 'Member has no savings record.')
                ->withInput();
        }

        // Check 1.5× rule (From requirements: "Loans are issued at a rate of 1.5 of your savings")
        $maxEligible = $member->savings->available_savings * 1.5;
        
        if ($validated['amount'] > $maxEligible) {
            return redirect()->back()
                ->with('error', 'Loan amount exceeds maximum eligibility of KES ' . number_format($maxEligible, 2))
                ->withInput();
        }

        // Check for active loans if applying for top-up
        $loanType = $request->loan_type ?? 'normal';
        
        if ($loanType === 'topup') {
            $activeLoan = $member->activeLoan;
            
            if (!$activeLoan) {
                return redirect()->back()
                    ->with('error', 'Member has no active loan for top-up.')
                    ->withInput();
            }
            
            // Check 50% repayment rule (From requirements: "paid upto 50% will be eligible for top up loans")
            if (!$activeLoan->qualifiesForTopUp()) {
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
                ->with('error', 'Failed to submit loan application: ' . $e->getMessage())
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
                'transaction_ref' => 'WD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'balance_before' => $withdrawalResult['new_balance'] + $request->amount + 2000, // Include retained amount
                'balance_after' => $withdrawalResult['new_balance'],
                'status' => 'pending', // Will be completed when cheque is issued
                'description' => 'Savings withdrawal - ' . $request->reason,
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
                ->with('success', 'Withdrawal request processed. Cheque number ' . $cheque->cheque_number . ' issued to Treasurer.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Withdrawal failed: ' . $e->getMessage())
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
        
        $sequence = $lastCheque ? (int)substr($lastCheque->cheque_number, -4) + 1 : 1;
        
        return "CHQ-{$date}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
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