<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        // Safety check if user somehow bypassed middleware or record deleted
        if (! $user) {
            return redirect()->route('login');
        }

        $tenant = $user->tenant;
        $proposal = $tenant?->proposals()->latest()->first();

        return view('tenant.dashboard', compact('user', 'tenant', 'proposal'));
    }
}
