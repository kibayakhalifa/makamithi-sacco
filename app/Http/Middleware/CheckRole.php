<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        Log::info('=== ROLE MIDDLEWARE EXECUTING ===');
        Log::info('Route: ' . $request->route()->getName());
        Log::info('User authenticated: ' . (auth()->check() ? 'YES' : 'NO'));
        
        // If user is not authenticated, redirect to login
        if (!auth()->check()) {
            Log::warning('User not authenticated, redirecting to login');
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        Log::info('User role: ' . $user->role);
        Log::info('Required roles:', $roles);
        
        // Check if user has one of the required roles
        if (!in_array($user->role, $roles)) {
            Log::warning('User role not authorized', [
                'user_role' => $user->role,
                'required_roles' => $roles,
                'route' => $request->route()->getName()
            ]);
            
            // Return 403 Forbidden
            abort(403, 'Unauthorized. You do not have the required role.');
        }
        
        Log::info('Role check PASSED for user: ' . $user->name);
        
        return $next($request);
    }
}