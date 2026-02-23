<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if (session('wdp_access') === true) {
            return redirect()->route('tenant.dashboard');
        }

        return view('auth.login');
    }

    public function tenantLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        if (Auth::user()->role !== 'tenant') {
            Auth::logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Akun ini bukan akun tenant.']);
        }

        $request->session()->regenerate();
        $request->session()->put('wdp_access', true);

        return redirect()->route('tenant.dashboard');
    }

    public function register(): View
    {
        $a = rand(1, 15);
        $b = rand(1, 15);
        session(['captcha_answer' => $a + $b]);

        return view('auth.register', compact('a', 'b'));
    }

    public function tenantRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' => ['required', 'integer'],
        ]);

        if ((int) $request->captcha !== (int) session('captcha_answer')) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['captcha' => 'Jawaban captcha salah.']);
        }

        User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->nomor_telepon,
            'password' => $request->password,
            'role' => 'tenant',
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function tenantLogout(Request $request): RedirectResponse
    {
        $request->session()->forget(['wdp_access', 'wdp_keycode']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showAdminLogin(): View
    {
        return view('admin.login');
    }

    public function adminLogin(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        if (! Auth::user()->isAdmin()) {
            Auth::logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Anda tidak memiliki akses admin.']);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
