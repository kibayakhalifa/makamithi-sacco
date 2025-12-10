<?php

use App\Http\Controllers\ChairmanController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

// Home page - Show different content based on auth status
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
});

// Include Breeze authentication routes
require __DIR__.'/auth.php';

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

    // ---------- MEMBER ROUTES ----------
    Route::middleware(['auth', 'role:member'])->group(function () {

        // Member Dashboard
        Route::get('/member/dashboard', function () {
            return view('member.dashboard');
        })->name('member.dashboard');

        // Savings routes
        Route::prefix('savings')->group(function () {
            Route::get('/', function () {
                return view('savings.index');
            })->name('savings.index');

            Route::get('/statements', function () {
                return view('savings.statements');
            })->name('savings.statements');

            Route::get('/withdrawal', function () {
                return view('savings.withdrawal');
            })->name('savings.withdrawal');
        });

        // Loan routes
        Route::prefix('loans')->group(function () {
            Route::get('/apply', function () {
                return view('loans.apply');
            })->name('loans.apply');

            Route::get('/my-loans', function () {
                return view('loans.my-loans');
            })->name('loans.my-loans');

            Route::get('/top-up', function () {
                return view('loans.top-up');
            })->name('loans.top-up');
        });

        // Profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', function () {
                return view('profile.index');
            })->name('profile.index');

            Route::get('/edit', function () {
                return view('profile.edit');
            })->name('profile.edit');

            Route::get('/next-of-kin', function () {
                return view('profile.next-of-kin');
            })->name('profile.next-of-kin');
        });
    });

    // ---------- CHAIRMAN ROUTES ----------
    Route::middleware(['auth', 'role:chairman'])->group(function () {

        // Chairman Dashboard
        Route::get('/chairman/dashboard', function () {
            return view('chairman.dashboard');
        })->name('chairman.dashboard');

        // Chairman specific routes
        Route::prefix('chairman')->group(function () {
            Route::get('/loan-approvals', function () {
                return view('chairman.loan-approvals');
            })->name('chairman.loan-approvals');

            Route::get('/members', function () {
                return view('chairman.members');
            })->name('chairman.members');
        });
    });

    // ---------- SECRETARY ROUTES ----------
    Route::middleware(['auth', 'role:secretary'])->group(function () {

        // Secretary Dashboard
        Route::get('/secretary/dashboard', function () {
            return view('secretary.dashboard');
        })->name('secretary.dashboard');

        // Secretary specific routes
        Route::prefix('secretary')->group(function () {
            // Member Management
            Route::get('/members', function () {
                return view('secretary.members');
            })->name('secretary.members');

            // Pending Approvals
            Route::get('/pending-approvals', function () {
                return view('secretary.pending-approvals');
            })->name('secretary.pending-approvals');

            // Loan Assistance
            Route::get('/loan-assist', function () {
                return view('secretary.loan-assist');
            })->name('secretary.loan-assist');

            // Dummy POST routes for forms (will work with JavaScript dummy data)
            Route::post('/members', function () {
                // Mock successful submission
                return redirect()->route('secretary.dashboard')
                    ->with('success', 'Member added successfully! Waiting for Chairman approval.');
            })->name('secretary.members.store');

            Route::post('/assisted-loans', function () {
                // Mock successful submission
                return redirect()->route('secretary.dashboard')
                    ->with('success', 'Loan application submitted! Sent to Chairman for approval.');
            })->name('secretary.loans.assisted');
        });
        // Secretary Communications
        Route::get('/secretary/communications', function () {
            if (auth()->user()->role !== 'secretary') {
                abort(403, 'Unauthorized access.');
            }

            return view('secretary.communications');
        })->name('secretary.communications');

        // Secretary Documents
        Route::get('/secretary/documents', function () {
            if (auth()->user()->role !== 'secretary') {
                abort(403, 'Unauthorized access.');
            }

            return view('secretary.documents');
        })->name('secretary.documents');
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

    Route::middleware(['auth'])->group(function () {
        Route::get('/documents', function () {
            return view('documents.index');
        })->name('documents.index');

        Route::get('/documents-test', function () {
            return view('documents.test-simple');
        })->name('documents.test');
    });

    // Secretary Routes
    Route::prefix('secretary')->middleware(['auth', 'role:secretary'])->group(function () {
        Route::post('/members', [SecretaryController::class, 'storeMember'])->name('secretary.members.store');
        Route::post('/assisted-loans', [SecretaryController::class, 'storeAssistedLoan'])->name('secretary.loans.assisted');
        Route::post('/withdrawal/{member}', [SecretaryController::class, 'processWithdrawalRequest'])->name('secretary.withdrawal.process');
    });

    // Chairman Routes
    Route::prefix('chairman')->middleware(['auth', 'role:chairman'])->group(function () {
        Route::post('/members/{member}/approve', [ChairmanController::class, 'approveMember'])->name('chairman.members.approve');
        Route::post('/loans/{loan}/approve', [ChairmanController::class, 'approveLoan'])->name('chairman.loans.approve');
    });

    Route::middleware(['auth', 'role:treasurer'])->prefix('treasurer')->name('treasurer.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [TreasurerController::class, 'dashboard'])->name('dashboard');

        // 1. Payment Processing
        Route::get('/payments', [TreasurerController::class, 'payments'])->name('payments');
        Route::post('/loans/{loan}/process-payment', [TreasurerController::class, 'processLoanPayment'])->name('loans.process-payment');
        Route::post('/loans/{loan}/issue-cheque', [TreasurerController::class, 'issueCheque'])->name('loans.issue-cheque');
        Route::post('/payroll/process-deductions', [TreasurerController::class, 'processPayrollDeductions'])->name('payroll.process-deductions');
        Route::post('/withdrawals/{transaction}/process', [TreasurerController::class, 'processWithdrawal'])->name('withdrawals.process');
        Route::post('/withdrawals/{transaction}/reject', [TreasurerController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
        Route::post('/withdrawals/process-all', [TreasurerController::class, 'processAllWithdrawals'])->name('withdrawals.process-all');

        // 2. Loans Management
        Route::get('/loans', [TreasurerController::class, 'loans'])->name('loans');
        Route::post('/loans/{loan}/payment', [TreasurerController::class, 'recordLoanPayment'])->name('loans.record-payment');
        Route::post('/loans/send-reminders', [TreasurerController::class, 'sendPaymentReminders'])->name('loans.send-reminders');
        Route::post('/loans/update-rates', [TreasurerController::class, 'updateInterestRates'])->name('loans.update-rates');
        Route::get('/loans/export', [TreasurerController::class, 'exportLoans'])->name('loans.export');

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

        // Documents (shared with other roles)
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
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
    // Member Routes
    Route::middleware(['auth', 'role:member'])->group(function () {
        Route::post('/loans/apply', [LoanController::class, 'apply'])->name('member.loans.apply');
        Route::post('/savings/topup', [SavingsController::class, 'topup'])->name('member.savings.topup');
    });
    
});
