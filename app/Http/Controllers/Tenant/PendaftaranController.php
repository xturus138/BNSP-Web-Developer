<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\PendaftaranService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    // [Metode 2: Dependency Injection] — Service di-inject via constructor
    // Laravel otomatis resolve dari Service Container
    public function __construct(public PendaftaranService $pendaftaranService) {}

    public function index(): View|RedirectResponse
    {
        // Jika user sudah punya tenant → redirect ke detail
        if (Auth::user()->tenant) {
            return redirect()->route('tenant.detail')
                ->with('info', 'Anda sudah terdaftar sebagai tenant.');
        }

        return view('tenant.pendaftaran');
    }

    /**
     * [Metode 1: Controller store()] — Alur: Request → validate() → service->store() → redirect
     * [Metode 3: CSRF] — Token otomatis diverifikasi oleh middleware sebelum method ini dipanggil
     * [Metode 4: @error + old()] — Jika validate() gagal, Laravel redirect back() + flash $errors + old input
     */
    public function store(Request $request): RedirectResponse
    {
        // [SAFETY CHECK] Pastikan user belum punya tenant (mencegah bypass via endpoint)
        if (Auth::user()->tenant) {
            return redirect()->route('tenant.detail')
                ->with('info', 'Anda sudah terdaftar sebagai tenant.');
        }

        // [Metode 1: Validasi] — validate() semua field, termasuk MIME & ukuran untuk file
        $validated = $request->validate([
            // Tenant
            'nama_tenant' => ['required', 'string', 'max:255'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'no_hp_usaha' => ['nullable', 'string', 'max:20'],
            'alamat_usaha' => ['nullable', 'string', 'max:255'],
            'media_sosial' => ['nullable', 'string', 'max:255'],

            // Proposal
            'judul_proposal' => ['required', 'string', 'max:255'],
            'file_dokumen' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],

            // Produk
            'nama_produk' => ['required', 'string', 'max:255'],
            'detail_produk' => ['required', 'string', 'max:2000'],
            'harga' => ['nullable', 'string', 'max:50'],
            'foto_produk' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Anggota Tim (array of objects)
            'anggota' => ['required', 'array', 'min:1'],
            'anggota.*.nama_anggota' => ['required', 'string', 'max:255'],
            'anggota.*.nim' => ['required', 'string', 'max:20'],
            'anggota.*.prodi' => ['nullable', 'string', 'max:100'],
            'anggota.*.fakultas' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            // [Metode 1 & 2: Delegasi ke Service] — Controller tidak menyentuh Model langsung
            $validated['user_id'] = Auth::id();

            $this->pendaftaranService->store(
                data: $validated,
                anggota: $validated['anggota'],
                logo: $request->file('logo'),
                fileDokumen: $request->file('file_dokumen'),
                fotoProduk: $request->file('foto_produk'),
            );

            // [Metode 1: Redirect + flash success]
            return redirect()->route('tenant.dashboard')
                ->with('success', 'Pendaftaran tenant berhasil diajukan!');
        } catch (\Exception $e) {
            // [Metode 1: Error handling + Log]
            Log::error('Gagal pendaftaran tenant: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan pendaftaran. Silakan coba lagi.');
        }
    }
}
