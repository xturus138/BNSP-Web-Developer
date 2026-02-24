<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KeycodeAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // [DEMO READY] Cegah admin masuk ke area tenant via URL manual
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return $next($request);
        }

        if (session('wdp_access') === true) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
