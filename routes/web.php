<?php

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

    // ---------- TREASURER ROUTES ----------
    Route::middleware(['auth', 'role:treasurer'])->group(function () {

        // Treasurer Dashboard
        Route::get('/treasurer/dashboard', function () {
            return view('treasurer.dashboard');
        })->name('treasurer.dashboard');

        // Treasurer specific routes
        Route::prefix('treasurer')->group(function () {
            Route::get('/payments', function () {
                return view('treasurer.payments');
            })->name('treasurer.payments');

            Route::get('/expenses', function () {
                return view('treasurer.expenses');
            })->name('treasurer.expenses');
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

});
