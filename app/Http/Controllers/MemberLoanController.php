<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanTopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberLoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:member');
    }

    /**
     * Display member loans
     */
    public function index()
    {
        $user = Auth::user();

        $loans = $user->loans()
            ->with([
                'payments' => function ($query) {
                    $query->orderBy('payment_date', 'desc');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $eligibility = $user->loan_eligibility;
        $activeLoans = $loans->whereIn('status', ['active', 'disbursed']);

        // Add these lines to calculate first and second loans
        $firstLoan = $user->loans()
            ->whereIn('status', ['active', 'disbursed', 'approved'])
            ->where('loan_type', 'first_loan')
            ->first();

        $secondLoan = $user->loans()
            ->whereIn('status', ['active', 'disbursed', 'approved'])
            ->where('loan_type', 'second_loan')
            ->first();

        $canApplySecond = $firstLoan && $firstLoan->percentage_paid >= 50 && !$secondLoan;

        return view('member.loans.index', compact(
            'loans',
            'eligibility',
            'activeLoans',
            'firstLoan',
            'secondLoan',
            'canApplySecond'
        ));
    }

    /**
     * Show loan application form
     */
    public function create()
    {
        $user = Auth::user();
        $savings = $user->savings;

        if (!$savings) {
            return redirect()->route('member.dashboard')
                ->with('error', 'You need a savings account to apply for a loan.');
        }

        $eligibility = $user->loan_eligibility;

        // Check for active first loan
        $firstLoan = $user->loans()
            ->whereIn('status', ['active', 'disbursed', 'approved'])
            ->where('loan_type', 'first_loan')
            ->first();
        $hasActiveFirstLoan = !is_null($firstLoan);

        // Check for active second loan
        $secondLoan = $user->loans()
            ->whereIn('status', ['active', 'disbursed', 'approved'])
            ->where('loan_type', 'second_loan')
            ->first();
        $hasActiveSecondLoan = !is_null($secondLoan);

        // Check if eligible for second loan (50% repayment of first loan)
        $isEligibleForSecondLoan = false;
        $secondLoanEligibility = 0;

        if ($hasActiveFirstLoan && $firstLoan && !$hasActiveSecondLoan) {
            $isEligibleForSecondLoan = $firstLoan->percentage_paid >= 50;

            if ($isEligibleForSecondLoan) {
                // Calculate second loan eligibility
                // Sum of all active loans
                $totalActiveLoans = $user->loans()
                    ->whereIn('status', ['active', 'disbursed', 'approved'])
                    ->whereIn('loan_type', ['first_loan', 'second_loan'])
                    ->sum('remaining_balance');
                $secondLoanEligibility = max(0, $eligibility - $totalActiveLoans);
                $secondLoanEligibility = max(5000, $secondLoanEligibility); // Minimum 5,000
            }
        }

        return view('member.loans.apply', compact(
            'eligibility',
            'hasActiveFirstLoan',
            'hasActiveSecondLoan',
            'firstLoan',
            'isEligibleForSecondLoan',
            'secondLoanEligibility'
        ));
    }

    /**
     * Store loan application
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $savings = $user->savings;

        if (!$savings) {
            return redirect()->back()->with('error', 'No savings account found.');
        }

        $eligibility = $user->loan_eligibility;
        $loanType = $request->input('loan_type', 'first'); // 'first' or 'second'

        // Common validation rules
        $commonRules = [
            'amount' => ['required', 'numeric', 'min:5000'],
            'purpose' => ['required', 'string', 'max:500'],
            'period_months' => ['required', 'integer', 'min:6', 'max:60'],
            'agree_terms' => ['required', 'accepted'],
            'support_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];

        // Check loan type and eligibility
        if ($loanType === 'first') {
            // Check for existing active FIRST loan
            $hasActiveFirstLoan = $user->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->where('loan_type', 'first_loan')
                ->exists();

            if ($hasActiveFirstLoan) {
                return redirect()->back()->with(
                    'error',
                    'You already have an active first loan. Please repay 50% to qualify for a second loan.'
                );
            }

            // First loan: Max is min(eligibility, 1,000,000)
            $maxAmount = min($eligibility, 1000000);
            $commonRules['amount'][] = 'max:' . $maxAmount;

            $customMessages = [
                'amount.max' => 'Loan amount cannot exceed your eligibility of KES ' . number_format($maxAmount, 2),
            ];

        } else { // loan_type === 'second'
            // Check for active first loan
            $firstLoan = $user->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->where('loan_type', 'first_loan')
                ->first();

            if (!$firstLoan) {
                return redirect()->back()->with(
                    'error',
                    'You need an active first loan to apply for a second loan.'
                );
            }

            // Check if eligible for second loan (50% repayment)
            if ($firstLoan->percentage_paid < 50) {
                return redirect()->back()->with(
                    'error',
                    'You need to repay 50% of your first loan to qualify for a second loan. ' .
                    'Currently at ' . number_format($firstLoan->percentage_paid, 1) . '% repaid.'
                );
            }

            // Check if user already has an active second loan
            $hasActiveSecondLoan = $user->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->where('loan_type', 'second_loan')
                ->exists();

            if ($hasActiveSecondLoan) {
                return redirect()->back()->with(
                    'error',
                    'You already have an active second loan. You cannot have more than two active loans.'
                );
            }

            // Calculate second loan eligibility
            // Total of all active loans cannot exceed eligibility
            $totalActiveLoans = $user->loans()
                ->whereIn('status', ['active', 'disbursed', 'approved'])
                ->whereIn('loan_type', ['first_loan', 'second_loan'])
                ->sum('remaining_balance');

            $secondLoanEligibility = max(0, $eligibility - $totalActiveLoans);
            $maxAmount = min($secondLoanEligibility, 1000000);

            if ($maxAmount < 5000) {
                return redirect()->back()->with(
                    'error',
                    'You have reached your maximum loan limit. ' .
                    'Your total loan balance (KES ' . number_format($totalActiveLoans, 2) . ') ' .
                    'exceeds your eligibility (KES ' . number_format($eligibility, 2) . ').'
                );
            }

            $commonRules['amount'][] = 'max:' . $maxAmount;

            $customMessages = [
                'amount.max' => 'Second loan amount cannot exceed your available limit of KES ' . number_format($maxAmount, 2),
            ];
        }

        $validator = Validator::make($request->all(), $commonRules, $customMessages ?? []);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Calculate loan details
            $periodMonths = (int) $request->period_months;
            $amount = (float) $request->amount;
            $interestRate = 5.0;
            $interestAmount = $amount * ($interestRate / 100);
            $totalRepayable = $amount + $interestAmount;
            $monthlyPayment = $totalRepayable / $periodMonths;

            // Handle support document upload
            $supportPath = null;
            if ($request->hasFile('support_document')) {
                $supportPath = $request->file('support_document')->store('loan_documents', 'public');
            }

            // Determine loan type for database
            $dbLoanType = $loanType === 'first' ? 'first_loan' : 'second_loan';

            // Get first loan for parent_loan_id if this is a second loan
            $parentLoanId = null;
            if ($loanType === 'second') {
                $firstLoan = $user->loans()
                    ->whereIn('status', ['active', 'disbursed', 'approved'])
                    ->where('loan_type', 'first_loan')
                    ->first();
                $parentLoanId = $firstLoan->id ?? null;
            }

            // Create loan application
            $loan = Loan::create([
                'user_id' => $user->id,
                'loan_number' => Loan::generateLoanNumber(),
                'loan_type' => $dbLoanType,
                'amount' => $amount,
                'interest_rate' => $interestRate,
                'interest_amount' => $interestAmount,
                'total_repayable' => $totalRepayable,
                'period_months' => $periodMonths,
                'monthly_payment' => $monthlyPayment,
                'amount_paid' => 0,
                'remaining_balance' => $totalRepayable,
                'months_paid' => 0,
                'months_remaining' => $periodMonths,
                'percentage_paid' => 0,
                'purpose' => $request->purpose,
                'application_type' => 'self',
                'status' => 'pending',
                'applied_date' => now()->toDateString(),
                'expected_completion_date' => now()->addMonths($periodMonths)->toDateString(),
                'support_document' => $supportPath,
                'parent_loan_id' => $parentLoanId,
            ]);

            DB::commit();

            // Send notification to member
            $user->notify(new \App\Notifications\LoanApplicationSubmitted($loan));

            $successMessage = $loanType === 'first'
                ? 'First loan application submitted successfully!'
                : 'Second loan application submitted successfully!';

            $successMessage .= ' It will be reviewed within 3-5 working days.';

            return redirect()->route('member.loans.index')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to submit loan application: ' . $e->getMessage());
        }
    }

    /**
     * Show loan details
     */
    // In app/Http/Controllers/MemberLoanController.php, update show method:

    public function show(Loan $loan)
    {
        $this->authorize('view', $loan);

        // Load basic data
        $loan->load([
            'payments' => function ($q) {
                $q->where('status', 'completed')->orderBy('payment_date');
            }
        ]);

        // Simple calculations
        $remainingBalance = $loan->remaining_balance;
        $percentagePaid = $loan->percentage_paid;

        // Calculate what should be displayed
        $monthsPaid = $loan->months_paid;
        $remainingMonths = max(1, $loan->period_months - $monthsPaid);
        $futureMonthly = ceil($remainingBalance / $remainingMonths);

        return view('member.loans.show', compact(
            'loan',
            'remainingBalance',
            'percentagePaid',
            'monthsPaid',
            'futureMonthly'
        ));
    }
    // Add print schedule method
    public function printSchedule(Loan $loan)
    {
        $this->authorize('view', $loan);

        $loan->load([
            'user',
            'schedules' => function ($query) {
                $query->orderBy('installment_number');
            }
        ]);

        // Generate schedule if not exists
        if ($loan->schedules->isEmpty()) {
            $loan->generateSchedule();
        }

        $schedule = $loan->getDynamicPaymentSchedule();

        return view('member.loans.print-schedule', compact('loan', 'schedule'));
    }

    /**
     * Generate dynamic payment schedule with recalculated monthly payments
     */
    private function generatePaymentSchedule(Loan $loan)
    {
        $schedule = [];
        $payments = $loan->payments->sortBy('payment_date');
        $monthsPaid = $payments->count();
        $totalPaid = $loan->amount_paid;
        $remainingBalance = $loan->total_repayable - $totalPaid;
        $monthsRemaining = $loan->period_months - $monthsPaid;

        // Calculate dynamic monthly payment based on remaining balance
        $dynamicMonthlyPayment = $monthsRemaining > 0 ? ceil($remainingBalance / $monthsRemaining) : 0;

        // Use appropriate start date based on loan status
        if ($loan->disbursed_date) {
            $startDate = $loan->disbursed_date;
        } elseif ($loan->approved_date) {
            $startDate = $loan->approved_date;
        } else {
            $startDate = $loan->applied_date;
        }

        $currentDate = now();
        $nextPaymentFound = false;

        for ($i = 1; $i <= $loan->period_months; $i++) {
            $dueDate = $startDate->copy()->addMonths($i);
            $isPastDue = $dueDate < $currentDate && $dueDate->endOfDay() < $currentDate;
            $isFuture = $dueDate > $currentDate;

            // Check if payment for this installment exists
            $payment = $payments->where('installment_number', $i)->first();

            if ($payment) {
                // Payment made for this installment
                $status = 'paid';
                $paidDate = $payment->payment_date;
                $amount = $payment->amount;
                $remainingBalance -= $amount;
                $isNext = false;
            } else {
                // No payment made yet
                $amount = $dynamicMonthlyPayment;
                $paidDate = null;

                if ($isPastDue && !$nextPaymentFound) {
                    // This is overdue (next payment)
                    $status = 'pending';
                    $isNext = true;
                    $nextPaymentFound = true;
                } elseif ($isFuture && !$nextPaymentFound) {
                    // This is the next future payment
                    $status = 'pending';
                    $isNext = true;
                    $nextPaymentFound = true;
                } else {
                    // Future payments
                    $status = 'pending';
                    $isNext = false;
                }
            }

            $schedule[] = [
                'installment' => $i,
                'due_date' => $dueDate,
                'amount' => $amount,
                'status' => $status,
                'paid_date' => $paidDate,
                'remaining_balance' => max(0, $remainingBalance),
                'is_next' => $isNext ?? false,
                'is_overdue' => $isPastDue && !$payment,
                'original_amount' => $loan->monthly_payment,
            ];
        }

        return $schedule;
    }

    /**
     * Process early repayment
     */
    public function processEarlyRepayment(Request $request, Loan $loan)
    {
        $this->authorize('view', $loan);

        if ($loan->status !== 'disbursed') {
            return redirect()->back()->with('error', 'Loan is not active.');
        }

        $remainingBalance = $loan->total_repayable - $loan->amount_paid;

        if ($remainingBalance <= 0) {
            return redirect()->back()->with('error', 'Loan is already paid off.');
        }

        DB::beginTransaction();
        try {
            // Create early repayment record
            $payment = new \App\Models\Payment([
                'loan_id' => $loan->id,
                'amount' => $remainingBalance,
                'payment_date' => now(),
                'status' => 'completed',
                'payment_method' => 'early_repayment',
                'reference' => 'EARLY-' . now()->timestamp,
                'installment_number' => $loan->payments->count() + 1,
                'is_early_repayment' => true,
                'remarks' => 'Full early repayment',
            ]);

            $payment->save();

            // Update loan
            $loan->amount_paid += $remainingBalance;
            $loan->remaining_balance = 0;
            $loan->months_paid = $loan->period_months;
            $loan->months_remaining = 0;
            $loan->percentage_paid = 100;

            if ($loan->amount_paid >= $loan->total_repayable) {
                $loan->status = 'completed';
                $loan->completed_date = now();
            }

            $loan->save();

            DB::commit();

            return redirect()->route('member.loans.show', $loan)
                ->with('success', 'Early repayment processed successfully. Loan is now fully paid.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to process early repayment: ' . $e->getMessage());
        }
    }

    /**
     * Show top-up loan form
     */
    public function topup(Loan $loan)
    {
        $this->authorize('view', $loan);

        // Check eligibility
        if ($loan->percentage_paid < 50) {
            return redirect()->route('member.loans.show', $loan)
                ->with('error', 'You need to repay 50% of your current loan to qualify for top-up.');
        }

        $user = Auth::user();
        $eligibility = $user->loan_eligibility;
        $totalActiveLoans = $user->loans()
            ->whereIn('status', ['active', 'disbursed'])
            ->sum('remaining_balance');

        $availableForTopup = $eligibility - $totalActiveLoans;

        if ($availableForTopup <= 0) {
            return redirect()->route('member.loans.show', $loan)
                ->with('error', 'You have reached your maximum loan limit. Increase your savings to qualify for more loans.');
        }

        return view('member.loans.topup', compact('loan', 'availableForTopup'));
    }

    /**
     * Store top-up loan application
     */
    public function storeTopup(Request $request, Loan $loan)
    {
        $this->authorize('view', $loan);

        // Check eligibility
        if ($loan->percentage_paid < 50) {
            return redirect()->back()->with('error', 'You need to repay 50% of your current loan to qualify for top-up.');
        }

        $user = Auth::user();
        $eligibility = $user->loan_eligibility;
        $totalActiveLoans = $user->loans()
            ->whereIn('status', ['active', 'disbursed'])
            ->where('id', '!=', $loan->id)
            ->sum('remaining_balance');

        $availableForTopup = $eligibility - $totalActiveLoans;

        $validator = Validator::make($request->all(), [
            'amount' => [
                'required',
                'numeric',
                'min:10000',
                'max:' . min($availableForTopup, 500000),
            ],
            'purpose' => ['required', 'string', 'max:255'],
            'repayment_period' => ['required', 'integer', 'min:6', 'max:24'],
            'terms' => ['required', 'accepted'],
        ], [
            'amount.max' => 'Top-up amount cannot exceed your available limit of KES ' . number_format($availableForTopup, 2),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Create top-up application
            $topup = LoanTopup::create([
                'loan_id' => $loan->id,
                'amount' => $request->amount,
                'purpose' => $request->purpose,
                'repayment_period' => $request->repayment_period,
                'interest_rate' => 5.0, // Fixed 5% interest
                'status' => 'pending',
                'applied_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('member.loans.show', $loan)
                ->with('success', 'Top-up application submitted successfully! It will be reviewed within 3-5 working days.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to submit top-up application: ' . $e->getMessage());
        }
    }

    /**
     * Create payment schedule for loan
     */
    private function createPaymentSchedule($loan)
    {
        $monthlyPayment = $loan->monthly_payment;
        $dueDate = now()->addMonth()->startOfMonth();

        for ($i = 1; $i <= $loan->repayment_period; $i++) {
            $loan->payments()->create([
                'payment_number' => $i,
                'due_date' => $dueDate->copy()->addMonths($i - 1),
                'amount_due' => $monthlyPayment,
                'status' => 'pending',
            ]);
        }
    }
}