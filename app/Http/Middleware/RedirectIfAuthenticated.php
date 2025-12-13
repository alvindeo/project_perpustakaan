<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                $user = auth()->guard($guard)->user();
                
                if ($user->role === 'admin' || $user->role === 'librarian') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('member.dashboard');
                }
            }
        }

        return $next($request);
    }
}
