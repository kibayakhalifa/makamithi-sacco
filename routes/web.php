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

// ============================================
// PROTECTED ROUTES - REQUIRE AUTHENTICATION
// ============================================
Route::middleware(['auth'])->group(function () {
    
    // ---------- MEMBER DASHBOARD ----------
    Route::get('/member/dashboard', function () {
        // Check if user is a member
        if (auth()->user()->role !== 'member') {
            abort(403, 'Unauthorized access. This area is for members only.');
        }
        
        // Render a simple view for now (we'll add Livewire later)
        return view('member.dashboard');
    })->name('member.dashboard');
    
    // ---------- CHAIRMAN DASHBOARD ----------
    Route::get('/chairman/dashboard', function () {
        // Check if user is chairman
        if (auth()->user()->role !== 'chairman') {
            abort(403, 'Unauthorized access. This area is for chairman only.');
        }
        
        return view('chairman.dashboard');
    })->name('chairman.dashboard');
    
    // ---------- TREASURER DASHBOARD ----------
    Route::get('/treasurer/dashboard', function () {
        // Check if user is treasurer
        if (auth()->user()->role !== 'treasurer') {
            abort(403, 'Unauthorized access. This area is for treasurer only.');
        }
        
        return view('treasurer.dashboard');
    })->name('treasurer.dashboard');
    
    // ---------- SECRETARY DASHBOARD ----------
    Route::get('/secretary/dashboard', function () {
        // Check if user is secretary
        if (auth()->user()->role !== 'secretary') {
            abort(403, 'Unauthorized access. This area is for secretary only.');
        }
        
        return view('secretary.dashboard');
    })->name('secretary.dashboard');
    
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
});