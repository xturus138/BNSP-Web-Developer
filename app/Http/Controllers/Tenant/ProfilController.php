<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('tenant.profil', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'nim' => ['nullable', 'string', 'max:20'],
            'prodi' => ['nullable', 'string', 'max:100'],
            'fakultas' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return redirect()->route('tenant.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
