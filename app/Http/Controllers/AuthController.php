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
    // =====================================================================
    // TENANT LOGIN
    // =====================================================================

    /**
     * [LOGIN] Tampilkan halaman login tenant.
     * Jika user sudah punya session aktif, redirect ke dashboard.
     */
    public function login(): View|RedirectResponse
    {
        // [Metode 2: Auth Facade] — Auth::check() mengecek apakah user sudah login
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // [Metode 5: Session] — cek session wdp_access untuk tenant
        if (session('wdp_access') === true) {
            return redirect()->route('tenant.dashboard');
        }

        return view('auth.login');
    }

    /**
     * [LOGIN] Proses login tenant via POST.
     *
     * Metode yang diimplementasikan di sini:
     * - Metode 1: Auth::attempt() → baris 53
     * - Metode 2: Validasi input → baris 46-49
     * - Metode 3: Hash::check() dipanggil otomatis di dalam Auth::attempt()
     * - Metode 5: Session regenerate + set wdp_access → baris 67-68
     */
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

    // =====================================================================
    // TENANT REGISTER
    // =====================================================================

    /**
     * [REGISTER] Tampilkan form registrasi + generate captcha.
     *
     * Metode yang diimplementasikan di sini:
     * - Metode 3: Captcha — generate soal acak, simpan jawaban di session
     */
    public function register(): View
    {
        // [Metode 3: Captcha] — generate dua angka acak
        $a = rand(1, 15);
        $b = rand(1, 15);
        // [Metode 3: Captcha] — simpan jawaban ke session, akan dibandingkan saat submit
        session(['captcha_answer' => $a + $b]);

        // Kirim $a dan $b ke Blade untuk ditampilkan sebagai soal: "{{ $a }} + {{ $b }} = ?"
        return view('auth.register', compact('a', 'b'));
    }

    /**
     * [REGISTER] Proses registrasi tenant via POST.
     *
     * Metode yang diimplementasikan di sini:
     * - Metode 1: Validasi + User::create() → baris 120-140
     * - Metode 2: Laravel validation rules (required, email, unique, confirmed) → baris 120-126
     * - Metode 3: Captcha check vs session → baris 128-132
     * - Metode 4: Data disimpan ke tabel users sesuai migrasi → baris 134-140
     * - Metode 5: Password auto-hash via cast 'hashed' di User model → baris 138
     */
    public function tenantRegister(Request $request): RedirectResponse
    {
        // [Metode 1 & 2: Validasi] — $request->validate() dengan Laravel built-in rules
        // Jika gagal, Laravel otomatis redirect back() + flash $errors ke Blade
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],       // unique: cek duplikat di DB
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],   // confirmed: harus cocok dengan password_confirmation
            'captcha' => ['required', 'integer'],
        ]);

        // [Metode 3: Captcha] — bandingkan jawaban user vs jawaban yang disimpan di session
        if ((int) $request->captcha !== (int) session('captcha_answer')) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['captcha' => 'Jawaban captcha salah.']);
        }

        // [Metode 1 & 4: User::create()] — simpan ke DB sesuai kolom di migrasi
        // [Metode 5: Password Hashing] — password otomatis di-hash karena cast 'hashed' di User model
        User::create([
            'name' => $request->nama_lengkap,      // kolom: string('name')
            'email' => $request->email,              // kolom: string('email')->unique()
            'no_hp' => $request->nomor_telepon,      // kolom: string('no_hp')->nullable()
            'password' => $request->password,        // kolom: string('password') — auto bcrypt via cast
            'role' => 'tenant',                      // kolom: enum('role', ['admin', 'tenant'])
        ]);

        // Redirect ke login dengan flash message 'success'
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // =====================================================================
    // TENANT LOGOUT
    // =====================================================================

    /**
     * [LOGOUT] Hapus session tenant dan redirect ke login.
     */
    public function tenantLogout(Request $request): RedirectResponse
    {
        // [Metode 5: Session] — hapus key wdp_access dan wdp_keycode dari session
        $request->session()->forget(['wdp_access', 'wdp_keycode']);
        // [Metode 5: Session] — hancurkan seluruh session (semua data hilang)
        $request->session()->invalidate();
        // [Metode 5: Session] — buat CSRF token baru (cegah reuse token lama)
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // =====================================================================
    // ADMIN LOGIN
    // =====================================================================

    /**
     * [ADMIN LOGIN] Tampilkan form login admin.
     */
    public function showAdminLogin(): View
    {
        return view('admin.login');
    }

    /**
     * [ADMIN LOGIN] Proses login admin via POST.
     * Sama seperti tenantLogin, tapi:
     * - Menggunakan AdminLoginRequest (Form Request terpisah) untuk validasi
     * - Mengecek isAdmin() bukan role === 'tenant'
     */
    public function adminLogin(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // [Metode 1: Auth::attempt()] — sama seperti tenant, Hash::check() otomatis
        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // [Metode 2: Auth Facade] — Auth::user()->isAdmin() cek role === 'admin'
        if (! Auth::user()->isAdmin()) {
            Auth::logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Anda tidak memiliki akses admin.']);
        }

        // [Metode 5: Session] — regenerate session ID setelah login berhasil
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // =====================================================================
    // ADMIN LOGOUT
    // =====================================================================

    /**
     * [ADMIN LOGOUT] Hapus session admin dan redirect ke admin login.
     */
    public function adminLogout(Request $request): RedirectResponse
    {
        // [Metode 2: Auth Facade] — Auth::logout() menghapus auth session
        Auth::logout();

        // [Metode 5: Session] — invalidate + regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
