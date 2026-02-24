<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DetailTenantController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (! $tenant) {
            return redirect()->route('tenant.pendaftaran')
                ->with('info', 'Silakan lengkapi pendaftaran startup Anda terlebih dahulu.');
        }

        $tenant->load(['proposals', 'produks', 'anggotaTims']);

        return view('tenant.detail', compact('tenant'));
    }
}
