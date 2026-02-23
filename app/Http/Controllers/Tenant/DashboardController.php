<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        $proposal = $tenant?->proposals()->latest()->first();

        return view('tenant.dashboard', compact('user', 'tenant', 'proposal'));
    }
}
