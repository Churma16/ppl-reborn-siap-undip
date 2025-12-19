<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // 1. Check if user is logged in
        if (! auth()->check()) {
            return redirect('login');
        }

        // 2. Check if the user's role matches the required role
        // Assuming your User model has a 'role' column
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action'); // Or redirect to home
        }

        return $next($request);
    }
}
