<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $userRole = Auth::check() ? strtolower(trim(Auth::user()->role)) : null;
        $requiredRole = strtolower(trim($role));

        if (!Auth::check() || $userRole !== $requiredRole) {
            // If the user is logged in but has the wrong role, redirect them to their correct dashboard
            if (Auth::check()) {
                if ($userRole === 'mitra') {
                    return redirect()->route('dashboard.mitra');
                } else {
                    return redirect()->route('dashboard.customer');
                }
            }
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
