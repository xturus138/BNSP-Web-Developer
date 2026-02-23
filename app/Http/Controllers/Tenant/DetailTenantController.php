<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DetailTenantController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (! $tenant) {
            return view('tenant.detail', ['tenant' => null]);
        }

        $tenant->load(['proposals', 'produks', 'anggotaTims']);

        return view('tenant.detail', compact('tenant'));
    }
}
