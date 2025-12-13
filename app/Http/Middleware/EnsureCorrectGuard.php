<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCorrectGuard
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $expectedGuard): Response
    {
        // Check if user is authenticated with the expected guard
        if (Auth::guard($expectedGuard)->check()) {
            return $next($request);
        }
        
        // If not authenticated with expected guard, check other guards
        // and redirect to appropriate dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        if (Auth::guard('member')->check()) {
            return redirect()->route('member.dashboard');
        }
        
        // If not authenticated at all, redirect to login
        return redirect()->route('login');
    }
}
