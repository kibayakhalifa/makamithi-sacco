<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Custom redirect based on role
        $user = Auth::user();
        
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
                return redirect()->intended(route('dashboard', absolute: false));
        }
    }
}