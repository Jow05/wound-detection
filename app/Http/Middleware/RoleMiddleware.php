<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Check jika user punya role yang dibutuhkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses
        abort(403, 'Unauthorized access.');
    }
}