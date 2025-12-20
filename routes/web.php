<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\ChairmanController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\MemberLoanController;
use App\Http\Controllers\MemberReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\MemberPaymentController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\MemberSavingsController;
use App\Http\Controllers\MemberDocumentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Main welcome page with login form - ONLY FOR GUESTS
Route::get('/', function () {
    if (auth()->check()) {
        // Redirect to appropriate dashboard
        $user = auth()->user();

        switch ($user->role) {
            case 'member':
                return redirect()->route('member.dashboard');
            case 'chairman':
                return redirect()->route('chairman.dashboard');
            case 'treasurer':
                return redirect()->route('treasurer.dashboard');
            case 'secretary':
                return redirect()->route('secretary.dashboard');
            default:
                return redirect()->route('member.dashboard');
        }
    }

    // Show welcome page for non-authenticated users
    return view('welcome');
})->name('welcome');

// POST route for login form submission
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

// Include Breeze authentication routes (excluding GET /login)
require __DIR__ . '/auth.php';

// Redirect GET /login to welcome page
Route::get('/login', function () {
    return redirect('/');
})->name('login.get');

Route::middleware(['auth'])->group(function () {

    // ---------- COMMON DASHBOARD REDIRECT ----------
    Route::get('/dashboard', function () {
        // Redirect to appropriate dashboard based on role
        $user = auth()->user();

        switch ($user->role) {
            case 'member':
                return redirect()->route('member.dashboard');
            case 'chairman':
                return redirect()->route('chairman.dashboard');
            case 'treasurer':
                return redirect()->route('treasurer.dashboard');
            case 'secretary':
                return redirect()->route('secretary.dashboard');
            default:
                return redirect()->route('member.dashboard');
        }
    })->name('dashboard');

    // ---------- LOGOUT ----------
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // ============ DOCUMENTS ROUTES (FOR ALL USERS) ============
    Route::middleware(['auth'])->group(function () {
        // Shared documents view (for all users)
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
    });

    // Member Routes (requires authentication and member role)
    Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');

        // Profile
        Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
        Route::patch('/profile', [MemberController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [MemberController::class, 'updatePassword'])->name('profile.password');
        //profile view
        Route::get('/profile', [MemberProfileController::class, 'index'])->name('profile');

        // Profile Update
        Route::patch('/profile', [MemberProfileController::class, 'update'])->name('profile.update');

        // Profile Picture Update
        Route::patch('/profile/picture', [MemberProfileController::class, 'updatePicture'])->name('profile.update-picture');
        Route::post('/documents', [MemberDocumentController::class, 'store'])->name('documents.store');
        Route::delete('/documents/{document}', [MemberDocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('/documents/{document}', [MemberDocumentController::class, 'show'])->name('documents.show');

        // Savings
        Route::get('/savings', [MemberSavingsController::class, 'index'])->name('savings.index');
        Route::post('/savings/topup', [MemberSavingsController::class, 'topup'])->name('savings.topup');
        Route::post('/savings/withdrawal-request', [MemberSavingsController::class, 'withdrawalRequest'])->name('savings.withdrawal-request');

        // Loans
        Route::get('/loans', [MemberLoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/apply', [MemberLoanController::class, 'create'])->name('loans.apply');
        Route::post('/loans/apply', [MemberLoanController::class, 'store'])->name('loans.store');
        Route::get('/loans/{loan}', [MemberLoanController::class, 'show'])->name('loans.show');
        Route::get('/loans/{loan}/topup', [MemberLoanController::class, 'topup'])->name('loans.topup');
        Route::post('/loans/{loan}/topup', [MemberLoanController::class, 'storeTopup'])->name('loans.topup.store');
        Route::get('/member/loans/{loan}', [MemberLoanController::class, 'show'])->name('member.loans.show');

        // Reports
        Route::get('/reports', [MemberReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [MemberReportController::class, 'generate'])->name('reports.generate');
        Route::get('/reports/download/{report}', [MemberReportController::class, 'download'])->name('reports.download');

        Route::get('/loans/{loan}/print-schedule', [MemberLoanController::class, 'printSchedule'])
            ->name('loans.print-schedule');
    });

    // ---------- CHAIRMAN ROUTES ----------
    Route::middleware(['auth', 'role:chairman'])->prefix('chairman')->name('chairman.')->group(function () {

        // Chairman Dashboard
        Route::get('/dashboard', [ChairmanController::class, 'dashboard'])->name('dashboard');

        // Members Management
        Route::get('/members', [ChairmanController::class, 'members'])->name('members');
        Route::get('/member/{member}/details', [ChairmanController::class, 'getMemberDetails'])->name('member.details');
        Route::get('/chairman/member/{id}/details', [ChairmanController::class, 'memberDetails'])
            ->name('chairman.member.details');
        Route::post('/member/{member}/approve', [ChairmanController::class, 'approveMember'])->name('member.approve');

        // Loan Approvals
        Route::get('/loan-approvals', [ChairmanController::class, 'loanApprovals'])->name('loan-approvals');
        Route::get('/loans/{loan}/approve', [ChairmanController::class, 'viewLoanForApproval'])->name('loans.approve-view');
        Route::post('/loans/{loan}/approve', [ChairmanController::class, 'approveLoanApplication'])->name('loans.approve');
        Route::post('/loans/{loan}/reject', [ChairmanController::class, 'rejectLoanApplication'])->name('loans.reject');

        // Reports and Statistics
        Route::get('/dashboard-stats', [ChairmanController::class, 'getDashboardStats'])->name('dashboard.stats');
        Route::get('/filtered-members', [ChairmanController::class, 'getFilteredMembers'])->name('members.filtered');
    });

    // ---------- SECRETARY ROUTES ----------
    Route::middleware(['auth', 'role:secretary'])->group(function () {

        // Secretary Dashboard
        // Secretary Dashboard
        Route::get('/secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');

        // Secretary specific routes
        Route::prefix('secretary')->group(function () {
            // ============ MEMBER MANAGEMENT ============
            // Member List
            Route::get('/members', [SecretaryController::class, 'members'])->name('secretary.members');

            // Create Member
            Route::get('/members/create', [SecretaryController::class, 'createMember'])->name('secretary.members.create');
            Route::post('/members', [SecretaryController::class, 'storeMember'])->name('secretary.members.store');

            // View/Edit/Delete Member
            Route::get('/members/{user}', [SecretaryController::class, 'showMember'])->name('secretary.members.show');
            Route::get('/members/{user}/edit', [SecretaryController::class, 'editMember'])->name('secretary.members.edit');
            Route::put('/members/{user}', [SecretaryController::class, 'updateMember'])->name('secretary.members.update');
            Route::delete('/members/{user}', [SecretaryController::class, 'destroyMember'])->name('secretary.members.destroy');

            // Member Approval Actions
            Route::post('/members/{user}/approve', [SecretaryController::class, 'approveMember'])->name('secretary.members.approve');
            Route::post('/members/{user}/reject', [SecretaryController::class, 'rejectMember'])->name('secretary.members.reject');

            // Member Exports
            Route::post('/members/export', [SecretaryController::class, 'exportMembers'])->name('secretary.members.export');

            // ============ LOAN MANAGEMENT ============
            // Pending Approvals View
            Route::get('/pending-approvals', function () {
                return view('secretary.pending-approvals');
            })->name('secretary.pending-approvals');

            // Loan Assistance
            Route::get('/loan-assist', function () {
                return view('secretary.loan-assist');
            })->name('loan-assist');
            Route::get('/secretary/loan-assist', function () {
                $members = \App\Models\User::where('role', 'member')
                    ->where('sacco_status', 'active')
                    ->orderBy('name')
                    ->get();

                return view('secretary.loan-assist', compact('members'));
            })->name('secretary.loan-assist')->middleware(['auth', 'role:secretary']);
            Route::post('/assisted-loans', [SecretaryController::class, 'storeAssistedLoan'])->name('secretary.loans.assisted');

            // Loan Approvals
            Route::get('/loan-approvals', [SecretaryController::class, 'loanApprovals'])->name('secretary.loan-approvals');
            Route::get('/loan-approvals/{loan}', [SecretaryController::class, 'loanApprovalDetail'])->name('secretary.loan-approval-detail');
            Route::post('/loan-approvals/{loan}/approve', [SecretaryController::class, 'approveLoanApplication'])->name('secretary.loans.approve');
            Route::post('/loan-approvals/{loan}/reject', [SecretaryController::class, 'rejectLoanApplication'])->name('secretary.loans.reject');

            // Loan History
            Route::get('/loan-history', [SecretaryController::class, 'loanHistory'])->name('secretary.loan-history');

            // Withdrawal Processing
            Route::post('/withdrawal/{member}', [SecretaryController::class, 'processWithdrawalRequest'])->name('secretary.withdrawal.process');

            // ============ COMMUNICATIONS ============
            Route::get('/communications', function () {
                return view('secretary.communications');
            })->name('secretary.communications');

            // ============ DOCUMENTS MANAGEMENT ============
            Route::get('/documents', [DocumentController::class, 'secretaryIndex'])->name('secretary.documents');
            Route::post('/documents', [DocumentController::class, 'store'])->name('secretary.documents.store');
            Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('secretary.documents.destroy');

            // ============ REPORTS ============
            Route::get('/reports/members/new', [SecretaryController::class, 'newMembersReport'])->name('secretary.reports.members.new');
            Route::get('/reports/savings', [SecretaryController::class, 'savingsReport'])->name('secretary.reports.savings');
            Route::get('/reports/departments', [SecretaryController::class, 'departmentReport'])->name('secretary.reports.departments');

            Route::post('/members/{user}/resend-credentials', [MemberController::class, 'resendCredentials'])
                ->name('secretary.members.resend-credentials');


            // ============ SETTINGS & PROFILE ============
            Route::get('/profile', function () {
                return view('secretary.profile');
            })->name('secretary.profile');
        });
    });
    // ---------- REPORTS ROUTES (Accessible to all authenticated users) ----------
    Route::prefix('reports')->group(function () {
        Route::get('/', function () {
            return view('reports.index');
        })->name('reports.index');

        Route::get('/financial-position', function () {
            return view('reports.financial-position');
        })->name('reports.financial-position');

        Route::get('/savings-summary', function () {
            return view('reports.savings-summary');
        })->name('reports.savings-summary');

        Route::get('/loan-balances', function () {
            return view('reports.loan-balances');
        })->name('reports.loan-balances');

        Route::get('/member-statements/{id}', function ($id) {
            // Check if user has permission to view this member's statement
            $user = auth()->user();
            if ($user->role === 'member' && $user->id != $id) {
                abort(403, 'You can only view your own statement.');
            }

            return view('reports.member-statement', ['memberId' => $id]);
        })->name('reports.member-statements');
    });

    // Secretary POST Routes (for assisted loans, withdrawals) - DUPLICATE ROUTES REMOVED
    Route::prefix('secretary')->middleware(['auth', 'role:secretary'])->group(function () {
        Route::post('/assisted-loans', [SecretaryController::class, 'storeAssistedLoan'])->name('secretary.loans.assisted');
        Route::post('/withdrawal/{member}', [SecretaryController::class, 'processWithdrawalRequest'])->name('secretary.withdrawal.process');
    });

    // Treasurer Routes
    Route::middleware(['auth', 'role:treasurer'])->prefix('treasurer')->name('treasurer.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [TreasurerController::class, 'dashboard'])->name('dashboard');

        // 1. Payment Processing
        Route::get('/payments', [TreasurerController::class, 'payments'])->name('payments');
        Route::post('/loans/{loan}/process-payment', [TreasurerController::class, 'processLoanPayment'])->name('loans.process-payment');
        Route::post('/loans/{loan}/issue-cheque', [TreasurerController::class, 'issueCheque'])->name('loans.issue-cheque');
        Route::post('/loans/{loan}/disburse', [TreasurerController::class, 'disburseLoan'])->name('loans.disburse');
        // Add this route definition
        Route::post('/loans/{loan}/payment', [TreasurerController::class, 'recordLoanPayment'])->name('treasurer.loans.record-payment');
        Route::post('/payroll/process-deductions', [TreasurerController::class, 'processPayrollDeductions'])->name('payroll.process-deductions');
        Route::post('/withdrawals/{transaction}/process', [TreasurerController::class, 'processWithdrawal'])->name('withdrawals.process');
        Route::post('/withdrawals/{transaction}/reject', [TreasurerController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
        Route::post('/withdrawals/process-all', [TreasurerController::class, 'processAllWithdrawals'])->name('withdrawals.process-all');

        // 2. Loans Management
        Route::get('/loans', [TreasurerController::class, 'loans'])->name('loans');
        Route::get('/loans/{loan}/view', [TreasurerController::class, 'viewLoan'])->name('loans.view');
        Route::post('/loans/send-reminders', [TreasurerController::class, 'sendPaymentReminders'])->name('loans.send-reminders');
        Route::post('/loans/update-rates', [TreasurerController::class, 'updateInterestRates'])->name('loans.update-rates');
        Route::get('/loans/export', [TreasurerController::class, 'exportLoans'])->name('loans.export');

        Route::post('/treasurer/loans/{loan}/record-payment', [App\Http\Controllers\TreasurerController::class, 'recordLoanPayment'])
            ->name('treasurer.loans.record-payment')
            ->middleware(['auth']);

        // 3. Savings Summary
        Route::get('/savings', [TreasurerController::class, 'savings'])->name('savings');
        Route::post('/savings/add-interest', [TreasurerController::class, 'addSavingsInterest'])->name('savings.add-interest');
        Route::get('/savings/transactions/export', [TreasurerController::class, 'exportSavingsTransactions'])->name('savings.transactions.export');
        Route::get('/savings/export', [TreasurerController::class, 'exportSavingsData'])->name('savings.export');

        // 4. Expenses Tracking
        Route::get('/expenses', [TreasurerController::class, 'expenses'])->name('expenses');
        Route::post('/expenses/{expense}/approve', [TreasurerController::class, 'approveExpense'])->name('expenses.approve');
        Route::post('/expenses/{expense}/reject', [TreasurerController::class, 'rejectExpense'])->name('expenses.reject');
        Route::post('/expenses/{expense}/pay', [TreasurerController::class, 'payExpense'])->name('expenses.pay');
        Route::post('/expenses/{expense}/issue-cheque', [TreasurerController::class, 'issueExpenseCheque'])->name('expenses.issue-cheque');
        Route::get('/expenses/export', [TreasurerController::class, 'exportExpenses'])->name('expenses.export');

        // 5. Cheque Management
        Route::get('/cheques', [TreasurerController::class, 'cheques'])->name('cheques');
        Route::post('/cheques/{cheque}/clear', [TreasurerController::class, 'recordChequeClearance'])->name('cheques.clear');
        Route::post('/cheques/{cheque}/cancel', [TreasurerController::class, 'cancelCheque'])->name('cheques.cancel');
        Route::get('/cheques/create', [TreasurerController::class, 'createCheque'])->name('cheques.create');
        Route::post('/cheques', [TreasurerController::class, 'storeCheque'])->name('cheques.store');
        Route::post('/cheques/batch-clear', [TreasurerController::class, 'batchClearCheques'])->name('cheques.batch-clear');
        Route::get('/cheques/export', [TreasurerController::class, 'exportCheques'])->name('cheques.export');

        // 6. Bank Reconciliation
        Route::get('/reconciliation', [TreasurerController::class, 'reconciliation'])->name('reconciliation');
        Route::post('/reconciliation/run', [TreasurerController::class, 'runReconciliation'])->name('reconciliation.run');
        Route::post('/reconciliation/reconcile-transactions', [TreasurerController::class, 'reconcileTransactions'])->name('reconciliation.reconcile-transactions');
        Route::post('/reconciliation/auto', [TreasurerController::class, 'autoReconcile'])->name('reconciliation.auto');
        Route::get('/reconciliation/{reconciliation}', [TreasurerController::class, 'showReconciliation'])->name('reconciliation.show');
        Route::get('/reconciliation/template', [TreasurerController::class, 'downloadTemplate'])->name('reconciliation.template');
        Route::get('/reconciliation/export', [TreasurerController::class, 'exportReconciliation'])->name('reconciliation.export');

        // 7. Financial Reports
        Route::get('/financial-reports', [TreasurerController::class, 'financialReports'])->name('financial-reports');
        Route::post('/financial-reports/export', [TreasurerController::class, 'exportReport'])->name('financial-reports.export');

        // Report Routes by Type
        Route::prefix('reports')->name('reports.')->group(function () {
            // Payment Reports
            Route::get('/payments/{type}', [TreasurerController::class, 'paymentReport'])->name('payments');
            Route::get('/payments/export', [TreasurerController::class, 'exportPayments'])->name('payments.export');

            // Loan Reports
            Route::get('/loans/{type}', [TreasurerController::class, 'loanReport'])->name('loans');
            Route::get('/loans/export', [TreasurerController::class, 'exportLoanReports'])->name('loans.export');

            // Savings Reports
            Route::get('/savings/{type}', [TreasurerController::class, 'savingsReport'])->name('savings');
            Route::get('/savings/export', [TreasurerController::class, 'exportSavingsReports'])->name('savings.export');

            // Expense Reports
            Route::get('/expenses/{type}', [TreasurerController::class, 'expenseReport'])->name('expenses');
            Route::get('/expenses/export', [TreasurerController::class, 'exportExpenseReports'])->name('expenses.export');

            // Cheque Reports
            Route::get('/cheques/{type}', [TreasurerController::class, 'chequeReport'])->name('cheques');
            Route::get('/cheques/export', [TreasurerController::class, 'exportChequeReports'])->name('cheques.export');

            // Reconciliation Reports
            Route::get('/reconciliation/{type}', [TreasurerController::class, 'reconciliationReport'])->name('reconciliation');
            Route::get('/reconciliation/export', [TreasurerController::class, 'exportReconciliationReports'])->name('reconciliation.export');

            // Financial Reports
            Route::get('/financial/{type}', [TreasurerController::class, 'financialReport'])->name('financial');
            Route::get('/financial/export', [TreasurerController::class, 'exportFinancialReports'])->name('financial.export');
        });
    });

    // ============ PAYROLL ROUTES (Treasurer Specific) ============
    Route::middleware(['auth', 'role:treasurer'])->prefix('treasurer/payroll')->name('treasurer.payroll.')->group(function () {
        Route::get('/upload', [TreasurerController::class, 'showPayrollUpload'])->name('upload');
        Route::post('/process', [TreasurerController::class, 'processPayroll'])->name('process');
        Route::get('/history', [TreasurerController::class, 'payrollHistory'])->name('history');
        Route::get('/export/{period}', [TreasurerController::class, 'exportPayroll'])->name('export');
    });

    // ============ BUDGET ROUTES ============
    Route::middleware(['auth', 'role:treasurer'])->prefix('treasurer/budget')->name('treasurer.budget.')->group(function () {
        Route::get('/', [TreasurerController::class, 'budget'])->name('index');
        Route::post('/update', [TreasurerController::class, 'updateBudget'])->name('update');
        Route::get('/report/{period}', [TreasurerController::class, 'budgetReport'])->name('report');
    });

    // ============ AUDIT TRAIL ROUTES ============
    Route::middleware(['auth', 'role:treasurer'])->prefix('treasurer/audit')->name('treasurer.audit.')->group(function () {
        Route::get('/', [TreasurerController::class, 'auditTrail'])->name('index');
        Route::get('/export', [TreasurerController::class, 'exportAuditTrail'])->name('export');
    });

    // ============ MEMBER STATEMENT ROUTES ============
    Route::middleware(['auth', 'role:treasurer'])->prefix('treasurer/statements')->name('treasurer.statements.')->group(function () {
        Route::get('/', [TreasurerController::class, 'memberStatements'])->name('index');
        Route::get('/generate/{member}', [TreasurerController::class, 'generateStatement'])->name('generate');
        Route::get('/bulk-generate', [TreasurerController::class, 'bulkGenerateStatements'])->name('bulk');
        Route::get('/export/{member}', [TreasurerController::class, 'exportStatement'])->name('export');
    });

    // Member Routes (additional)
    Route::middleware(['auth', 'role:member'])->group(function () {
        Route::post('/loans/apply', [LoanController::class, 'apply'])->name('member.loans.apply');
        Route::post('/savings/topup', [SavingsController::class, 'topup'])->name('member.savings.topup');
    });
    Route::get('/member/payments/{loan}/create', [MemberPaymentController::class, 'create'])
        ->name('member.payments.create')->middleware(['auth', 'role:member']);
    Route::post('/member/payments/{loan}', [MemberPaymentController::class, 'store'])
        ->name('member.payments.store')->middleware(['auth', 'role:member']);
    Route::post('/member/loans/{loan}/early-repayment', [MemberLoanController::class, 'processEarlyRepayment'])
        ->name('member.loans.early-repayment');
    Route::get('/member/profile/edit', [MemberProfileController::class, 'edit'])->name('member.profile.edit');
    Route::post('/member/profile/update', [MemberProfileController::class, 'update'])->name('member.profile.update');


    // ============ SETTINGS ROUTES ============
    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
        Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.update-notifications');
        Route::delete('/settings/delete-account', [SettingsController::class, 'deleteAccount'])->name('settings.delete-account');
    });

    Route::post('/reports/generate', [\App\Http\Controllers\ReportController::class, 'generate'])
        ->name('reports.generate');

    Route::middleware(['auth'])->group(function () {
        Route::get('/communications', [CommunicationController::class, 'index'])->name('communications.index');
        Route::get('/communications/create', [CommunicationController::class, 'create'])->middleware('role:chairman,secretary,treasurer')->name('communications.create');
        Route::post('/communications', [CommunicationController::class, 'store'])->middleware('role:chairman,secretary,treasurer')->name('communications.store');
        Route::get('/communications/{communication}', [CommunicationController::class, 'show'])->name('communications.show');
    });
    Route::get(
        '/notifications/{notification}',
        [NotificationController::class, 'open']
    )->name('notifications.open');

    Route::get('/communications/{communication}', [CommunicationController::class, 'show'])->name('communications.show');
    Route::delete('/communications/{communication}', [CommunicationController::class, 'destroy'])->name('communications.destroy');
    Route::get('/communications/{communication}/edit', [CommunicationController::class, 'edit'])->name('communications.edit');
    Route::put('/communications/{communication}', [CommunicationController::class, 'update'])->name('communications.update');
});
