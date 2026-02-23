@extends('layouts.tenant')

@section('title', 'Pendaftaran Tenant - INBISKOM')

@section('content')
{{-- Page Header --}}
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pendaftaran Tenant</h1>
        <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah ini untuk mendaftarkan usaha Anda</p>
    </div>
    <button type="button" onclick="isiOtomatis()"
        class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
        Isi Otomatis (Debug)
    </button>
</div>

{{-- [Metode 3: CSRF] — @csrf menghasilkan <input type="hidden" name="_token"> --}}
{{-- [Metode 1: enctype="multipart/form-data"] — WAJIB untuk upload file --}}

{{-- Flash Messages --}}
@if (session('success'))
<div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-2">
    <p class="text-sm text-green-700">{{ session('success') }}</p>
</div>
@endif
@if (session('error'))
<div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-2">
    <p class="text-sm text-red-700">{{ session('error') }}</p>
</div>
@endif

<form method="POST" action="{{ route('tenant.pendaftaran.store') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf

    {{-- ============================================================
         SECTION 1: Informasi Tenant
    ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">1</span>
            <h2 class="text-lg font-semibold text-gray-900">Informasi Tenant</h2>
        </div>

        <div class="grid grid-cols-2 gap-x-6 gap-y-5">

            {{-- Nama Tenant --}}
            <div>
                <label for="nama_tenant" class="block text-sm font-medium text-gray-700 mb-1">Nama Tenant <span class="text-red-500">*</span></label>
                <input
                    id="nama_tenant"
                    type="text"
                    name="nama_tenant"
                    placeholder="Masukkan nama usaha / tenant"
                    value="{{ old('nama_tenant') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('nama_tenant')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- No HP Usaha --}}
            <div>
                <label for="no_hp_usaha" class="block text-sm font-medium text-gray-700 mb-1">No. HP Usaha</label>
                <input
                    id="no_hp_usaha"
                    type="tel"
                    name="no_hp_usaha"
                    placeholder="Masukkan nomor telepon usaha"
                    value="{{ old('no_hp_usaha') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('no_hp_usaha')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat Usaha --}}
            <div>
                <label for="alamat_usaha" class="block text-sm font-medium text-gray-700 mb-1">Alamat Usaha</label>
                <input
                    id="alamat_usaha"
                    type="text"
                    name="alamat_usaha"
                    placeholder="Masukkan alamat usaha"
                    value="{{ old('alamat_usaha') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('alamat_usaha')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Media Sosial --}}
            <div>
                <label for="media_sosial" class="block text-sm font-medium text-gray-700 mb-1">Media Sosial</label>
                <input
                    id="media_sosial"
                    type="text"
                    name="media_sosial"
                    placeholder="Contoh: @namatenant (Instagram)"
                    value="{{ old('media_sosial') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('media_sosial')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi Singkat --}}
            <div class="col-span-2">
                <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea
                    id="deskripsi_singkat"
                    name="deskripsi_singkat"
                    rows="3"
                    placeholder="Jelaskan secara singkat tentang usaha Anda"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent resize-none">{{ old('deskripsi_singkat') }}</textarea>
                @error('deskripsi_singkat')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Logo — [Metode 4: File upload + preview] --}}
            <div class="col-span-2">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Tenant</label>
                <div class="flex items-center gap-4">
                    <label for="logo"
                        class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Pilih File
                    </label>
                    <span class="text-xs text-gray-400">PNG, JPG, WEBP, maksimal 2MB</span>
                    <span id="logo_name" class="text-xs text-gray-600 hidden"></span>
                    <input id="logo" type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewImage(this, 'logo_preview', 'logo_name')">
                </div>
                <img id="logo_preview" class="mt-2 h-20 rounded-lg border border-gray-200 hidden">
                @error('logo')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- ============================================================
         SECTION 2: Proposal Bisnis
    ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">2</span>
            <h2 class="text-lg font-semibold text-gray-900">Proposal Bisnis</h2>
        </div>

        <div class="grid grid-cols-2 gap-x-6 gap-y-5">

            {{-- Judul Proposal --}}
            <div class="col-span-2">
                <label for="judul_proposal" class="block text-sm font-medium text-gray-700 mb-1">Judul Proposal <span class="text-red-500">*</span></label>
                <input
                    id="judul_proposal"
                    type="text"
                    name="judul_proposal"
                    placeholder="Masukkan judul proposal bisnis"
                    value="{{ old('judul_proposal') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('judul_proposal')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- File Dokumen --}}
            <div class="col-span-2">
                <label for="file_dokumen" class="block text-sm font-medium text-gray-700 mb-1">File Proposal <span class="text-red-500">*</span></label>
                <div class="flex items-center gap-4">
                    <label for="file_dokumen"
                        class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Pilih Dokumen
                    </label>
                    <span class="text-xs text-gray-400">PDF, DOC, DOCX, maksimal 10MB</span>
                    <span id="file_dokumen_name" class="text-xs text-gray-600 hidden"></span>
                    <input id="file_dokumen" type="file" name="file_dokumen" accept=".pdf,.doc,.docx" class="hidden" onchange="showFileName(this, 'file_dokumen_name')">
                </div>
                @error('file_dokumen')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- ============================================================
         SECTION 3: Informasi Produk
    ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">3</span>
            <h2 class="text-lg font-semibold text-gray-900">Informasi Produk</h2>
        </div>

        <div class="grid grid-cols-2 gap-x-6 gap-y-5">

            {{-- Nama Produk --}}
            <div>
                <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                <input
                    id="nama_produk"
                    type="text"
                    name="nama_produk"
                    placeholder="Masukkan nama produk utama"
                    value="{{ old('nama_produk') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('nama_produk')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga --}}
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input
                    id="harga"
                    type="text"
                    name="harga"
                    placeholder="Contoh: Rp 50.000"
                    value="{{ old('harga') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('harga')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Detail Produk --}}
            <div class="col-span-2">
                <label for="detail_produk" class="block text-sm font-medium text-gray-700 mb-1">Detail Produk <span class="text-red-500">*</span></label>
                <textarea
                    id="detail_produk"
                    name="detail_produk"
                    rows="3"
                    placeholder="Jelaskan detail produk Anda"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent resize-none">{{ old('detail_produk') }}</textarea>
                @error('detail_produk')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Foto Produk --}}
            <div class="col-span-2">
                <label for="foto_produk" class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                <div class="flex items-center gap-4">
                    <label for="foto_produk"
                        class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Pilih Foto
                    </label>
                    <span class="text-xs text-gray-400">PNG, JPG, WEBP, maksimal 2MB</span>
                    <span id="foto_produk_name" class="text-xs text-gray-600 hidden"></span>
                    <input id="foto_produk" type="file" name="foto_produk" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewImage(this, 'foto_produk_preview', 'foto_produk_name')">
                </div>
                <img id="foto_produk_preview" class="mt-2 h-20 rounded-lg border border-gray-200 hidden">
                @error('foto_produk')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- ============================================================
         SECTION 4: Anggota Tim
    ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6" x-data="anggotaTim()">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">4</span>
                <h2 class="text-lg font-semibold text-gray-900">Anggota Tim</h2>
            </div>
            <button type="button" @click="tambahAnggota()"
                class="flex items-center gap-1.5 text-sm text-sky-600 hover:text-sky-700 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Anggota
            </button>
        </div>

        {{-- Dynamic Anggota Rows --}}
        <template x-for="(anggota, index) in daftarAnggota" :key="index">
            <div class="grid grid-cols-4 gap-4 mb-4 items-end">
                {{-- Nama --}}
                <div>
                    <label :for="'nama_anggota_' + index" class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota <span class="text-red-500">*</span></label>
                    <input
                        :id="'nama_anggota_' + index"
                        type="text"
                        :name="'anggota[' + index + '][nama_anggota]'"
                        placeholder="Nama lengkap"
                        x-model="anggota.nama_anggota"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                </div>

                {{-- NIM --}}
                <div>
                    <label :for="'nim_' + index" class="block text-sm font-medium text-gray-700 mb-1">NIM <span class="text-red-500">*</span></label>
                    <input
                        :id="'nim_' + index"
                        type="text"
                        :name="'anggota[' + index + '][nim]'"
                        placeholder="NIM"
                        x-model="anggota.nim"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                </div>

                {{-- Prodi --}}
                <div>
                    <label :for="'prodi_' + index" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <input
                        :id="'prodi_' + index"
                        type="text"
                        :name="'anggota[' + index + '][prodi]'"
                        placeholder="Program studi"
                        x-model="anggota.prodi"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                </div>

                {{-- Fakultas + Delete --}}
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label :for="'fakultas_' + index" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <input
                            :id="'fakultas_' + index"
                            type="text"
                            :name="'anggota[' + index + '][fakultas]'"
                            placeholder="Fakultas"
                            x-model="anggota.fakultas"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                    </div>
                    <button type="button" @click="hapusAnggota(index)" x-show="daftarAnggota.length > 1"
                        class="p-2.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        {{-- Empty state --}}
        <p class="text-xs text-gray-400 mt-2">Minimal 1 anggota tim harus diisi</p>
    </div>

    {{-- ============================================================
         SUBMIT
    ============================================================ --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('tenant.dashboard') }}"
            class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
            ← Kembali ke Dashboard
        </a>
        <button type="submit"
            class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Kirim Pendaftaran
        </button>
    </div>

</form>

{{-- Alpine.js: Anggota Tim dynamic rows --}}
<script>
    function anggotaTim() {
        return {
            daftarAnggota: [{
                nama_anggota: '',
                nim: '',
                prodi: '',
                fakultas: ''
            }],
            tambahAnggota() {
                this.daftarAnggota.push({
                    nama_anggota: '',
                    nim: '',
                    prodi: '',
                    fakultas: ''
                });
            },
            hapusAnggota(index) {
                this.daftarAnggota.splice(index, 1);
            }
        };
    }

    function isiOtomatis() {
        const pick = arr => arr[Math.floor(Math.random() * arr.length)];
        const randNum = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;

        const namaTenant = [
            'Kopi Nusantara', 'Bakso Juara', 'Teh Artisan Bandung', 'Keripik Maicih',
            'Dimsum Corner', 'Roti Bakar Gembira', 'Juice Lab', 'Mie Ayam Mantap',
            'Sate Taichan Express', 'Burger Lokal', 'Es Kopi Susu Kekinian', 'Pisang Nugget'
        ];
        const deskripsi = [
            'Usaha kuliner yang menyajikan makanan khas Indonesia dengan sentuhan modern dan bahan-bahan lokal berkualitas.',
            'Bisnis minuman kreatif yang menggabungkan resep tradisional dengan inovasi kekinian untuk generasi muda.',
            'Startup F&B yang fokus pada makanan sehat dan ramah lingkungan dengan kemasan biodegradable.',
            'Usaha makanan ringan homemade yang sudah memiliki pelanggan setia di kalangan mahasiswa Unikom.'
        ];
        const alamat = [
            'Jl. Dipatiukur No. 102, Bandung', 'Jl. Cihampelas No. 45, Bandung',
            'Jl. Sukajadi No. 78, Bandung', 'Jl. Dago Atas No. 33, Bandung',
            'Jl. Buah Batu No. 15, Bandung', 'Jl. Setiabudi No. 99, Bandung'
        ];
        const judulProposal = [
            'Proposal Bisnis Kuliner Digital Berbasis Aplikasi Mobile',
            'Rencana Pengembangan Usaha Makanan Sehat untuk Mahasiswa',
            'Proposal Startup Minuman Kekinian dengan Konsep Ramah Lingkungan',
            'Bisnis Plan: Ekspansi Produk Makanan Ringan ke Marketplace Online'
        ];
        const namaProduk = [
            'Es Kopi Susu Gula Aren', 'Bakso Urat Spesial', 'Keripik Singkong Pedas',
            'Roti Bakar Coklat Keju', 'Dimsum Ayam Premium', 'Juice Alpukat Kopi',
            'Nasi Goreng Kambing', 'Sate Taichan Original'
        ];
        const detailProduk = [
            'Produk unggulan kami yang dibuat dari bahan-bahan segar pilihan. Proses pembuatan higienis dengan standar food safety.',
            'Menu best seller yang sudah terjual lebih dari 500 porsi per bulan. Menggunakan resep turun-temurun dengan sentuhan modern.',
            'Produk inovatif yang menggabungkan cita rasa lokal dengan presentasi modern, cocok untuk semua kalangan.'
        ];
        const namaAnggota = [
            'Ahmad Fauzi', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari',
            'Rizky Pratama', 'Anisa Rahma', 'Dimas Aditya', 'Putri Wulandari',
            'Fajar Nugroho', 'Rina Marlina'
        ];
        const prodi = [
            'Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi',
            'Desain Komunikasi Visual', 'Ilmu Komunikasi', 'Teknik Elektro'
        ];
        const fakultas = [
            'Fakultas Teknik dan Ilmu Komputer', 'Fakultas Ekonomi dan Bisnis',
            'Fakultas Desain', 'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Fakultas Sastra'
        ];

        // Section 1: Informasi Tenant
        document.getElementById('nama_tenant').value = pick(namaTenant);
        document.getElementById('no_hp_usaha').value = '08' + randNum(1, 9) + randNum(10000000, 99999999);
        document.getElementById('alamat_usaha').value = pick(alamat);
        document.getElementById('media_sosial').value = '@' + pick(namaTenant).toLowerCase().replace(/\s+/g, '') + '_id';
        document.getElementById('deskripsi_singkat').value = pick(deskripsi);

        // Section 2: Proposal
        document.getElementById('judul_proposal').value = pick(judulProposal);

        // Section 3: Produk
        document.getElementById('nama_produk').value = pick(namaProduk);
        document.getElementById('harga').value = 'Rp ' + (randNum(1, 15) * 5000).toLocaleString('id-ID');
        document.getElementById('detail_produk').value = pick(detailProduk);

        // Section 4: Anggota Tim (via Alpine.js)
        const anggotaComponent = document.querySelector('[x-data="anggotaTim()"]').__x.$data;
        const jumlahAnggota = randNum(2, 4);
        const usedNames = [];
        anggotaComponent.daftarAnggota = [];
        for (let i = 0; i < jumlahAnggota; i++) {
            let nama;
            do {
                nama = pick(namaAnggota);
            } while (usedNames.includes(nama));
            usedNames.push(nama);
            anggotaComponent.daftarAnggota.push({
                nama_anggota: nama,
                nim: '1012' + randNum(0, 9) + randNum(100, 999),
                prodi: pick(prodi),
                fakultas: pick(fakultas)
            });
        }

        // File inputs: logo, file_dokumen, foto_produk — left for user
    }

    // [Metode 4: Preview image] — menampilkan preview gambar sebelum upload
    function previewImage(input, previewId, nameId) {
        const preview = document.getElementById(previewId);
        const nameSpan = document.getElementById(nameId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
            nameSpan.textContent = input.files[0].name;
            nameSpan.classList.remove('hidden');
        }
    }

    // [Metode 4: Show file name] — menampilkan nama file yang dipilih
    function showFileName(input, nameId) {
        const nameSpan = document.getElementById(nameId);
        if (input.files && input.files[0]) {
            nameSpan.textContent = input.files[0].name;
            nameSpan.classList.remove('hidden');
        }
    }
</script>
@endsection