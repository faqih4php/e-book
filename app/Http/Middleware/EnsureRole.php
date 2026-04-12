<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika belum login, redirect ke halaman login
        if (!$request->user()) {
            return redirect()->route('auths.login')->with('error', 'Please login first.');
        }

        // Jika sudah login tapi role tidak sesuai, tolak akses
        if ($request->user()->role !== $role) {
            abort(403, 'Access denied. You do not have permission to access this page.');
        }

        return $next($request);
    }
}
