<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if the user is even logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Check if the user's role matches the required role
        if (auth()->user()->role !== $role) {
            if (auth()->user()->role == 'user') {
                return redirect()->route('dashboard');
            } else if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}