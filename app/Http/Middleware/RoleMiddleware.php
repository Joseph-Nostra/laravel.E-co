<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return redirect('/admin')->with('error', 'Accès refusé aux administrateurs.');
            }
            return redirect('/login');
        }

        return $next($request);
    }
}
