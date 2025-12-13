<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanApplication;
use App\Models\LoanTopup;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            ->with(['payments' => function ($query) {
                $query->orderBy('payment_date', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $eligibility = $user->loan_eligibility;
        $activeLoans = $loans->whereIn('status', ['active', 'disbursed']);
        
        return view('member.loans.index', compact('loans', 'eligibility', 'activeLoans'));
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
        $hasActiveLoan = $user->activeLoan()->exists();
        
        return view('member.loans.apply', compact('eligibility', 'hasActiveLoan'));
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
        
        $validator = Validator::make($request->all(), [
            'amount' => [
                'required', 
                'numeric', 
                'min:5000', 
                'max:' . min($eligibility, 1000000)
            ],
            'purpose' => ['required', 'string', 'max:500'],
            'period_months' => ['required', 'integer', 'min:6', 'max:60'],
            'agree_terms' => ['required', 'accepted'],
            'support_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'amount.max' => 'Loan amount cannot exceed your eligibility of KES ' . number_format($eligibility, 2),
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            // Check if member has existing active loan
            $hasActiveLoan = $user->activeLoan()->exists();
            
            if ($hasActiveLoan) {
                return redirect()->back()->with('error', 
                    'You already have an active loan. Please repay 50% to qualify for a top-up.'
                );
            }
            
            // Calculate loan details
            $periodMonths = (int)$request->period_months;
            $amount = (float)$request->amount;
            $interestRate = 5.0;
            $interestAmount = $amount * ($interestRate / 100);
            $totalRepayable = $amount + $interestAmount;
            $monthlyPayment = $totalRepayable / $periodMonths;
            
            // Handle support document upload
            $supportPath = null;
            if ($request->hasFile('support_document')) {
                $supportPath = $request->file('support_document')->store('loan_documents', 'public');
            }

            // Create loan application
            $loan = Loan::create([
                'user_id' => $user->id,
                'loan_number' => Loan::generateLoanNumber(),
                'loan_type' => 'normal',
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
            ]);
            
            DB::commit();

            // Send notification to member
            $user->notify(new \App\Notifications\LoanApplicationSubmitted($loan));
            
            return redirect()->route('member.loans.index')
                ->with('success', 'Loan application submitted successfully! It will be reviewed within 3-5 working days.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit loan application: ' . $e->getMessage());
        }
    }

    /**
     * Show loan details
     */
    public function show(Loan $loan)
    {
        $this->authorize('view', $loan);
        
        $loan->load(['payments' => function ($query) {
            $query->orderBy('payment_date', 'asc');
        }, 'approver']);
        
        $remainingBalance = $loan->remaining_balance;
        $percentagePaid = $loan->percentage_paid;
        $isEligibleForTopup = $percentagePaid >= 50;
        
        return view('member.loans.show', compact('loan', 'remainingBalance', 'percentagePaid', 'isEligibleForTopup'));
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
                'max:' . min($availableForTopup, 500000)
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