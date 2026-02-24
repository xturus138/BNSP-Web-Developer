<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KeycodeAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ghost Session Handling: Jika session ada tapi user sudah dihapus di DB
        if (session('wdp_access') === true) {
            if (! auth()->check()) {
                session()->forget(['wdp_access', 'wdp_keycode']);

                return redirect()->route('login')->with('error', 'Sesi tidak valid atau akun Anda telah dihapus.');
            }

            // Cegah admin masuk ke area tenant via URL manual
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return $next($request);
        }

        return redirect()->route('login');
    }
}
