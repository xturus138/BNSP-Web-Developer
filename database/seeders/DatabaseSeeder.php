<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Produk;
use App\Models\Proposal;
use App\Models\AnggotaTim;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Passwordnya: password123
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Tenant Pertama
        $userTenant1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'no_hp' => '081234567890',
        ]);

        // Membuat Data Tenant untuk Budi
        $tenant1 = Tenant::create([
            'user_id' => $userTenant1->id,
            'nama_tenant' => 'Kopi Senja',
            'deskripsi_singkat' => 'Startup yang berfokus pada kopi nusantara.',
            'no_hp_usaha' => '081234567891',
            'alamat_usaha' => 'Jl. Merdeka No. 1, Jakarta',
        ]);

        // Membuat Data Produk untuk Tenant Kopi Senja
        Produk::create([
            'tenant_id' => $tenant1->id,
            'nama_produk' => 'Kopi Arabica Gayo',
            'detail_produk' => 'Biji kopi pilihan dari dataran tinggi Gayo.',
            'harga' => '50000',
        ]);

        Produk::create([
            'tenant_id' => $tenant1->id,
            'nama_produk' => 'Kopi Robusta Lampung',
            'detail_produk' => 'Kopi dengan rasa strong dan autentik.',
            'harga' => '45000',
        ]);

        // Membuat Data Proposal untuk Tenant Kopi Senja
        Proposal::create([
            'tenant_id' => $tenant1->id,
            'judul_proposal' => 'Pengembangan Mesin Roasting Kopi Pintar',
            'file_dokumen' => 'proposal_kopi_senja.pdf',
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        // Membuat Data Anggota Tim untuk Tenant Kopi Senja
        AnggotaTim::create([
            'tenant_id' => $tenant1->id,
            'nama_anggota' => 'Budi Santoso',
            'nim' => '19001111',
            'prodi' => 'Teknik Informatika',
        ]);

        AnggotaTim::create([
            'tenant_id' => $tenant1->id,
            'nama_anggota' => 'Siti Aminah',
            'nim' => '19001112',
            'prodi' => 'Sistem Informasi',
        ]);

        // ---------------------------------------------------------

        // 3. Membuat Akun Tenant Kedua (Contoh lain)
        $userTenant2 = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'no_hp' => '089876543210',
        ]);

        $tenant2 = Tenant::create([
            'user_id' => $userTenant2->id,
            'nama_tenant' => 'Tech Dev Solutions',
            'deskripsi_singkat' => 'Perusahaan pembuat software ERP kustom.',
            'no_hp_usaha' => '089876543211',
            'alamat_usaha' => 'Jl. Sudirman No. 45, Bandung',
        ]);

        Produk::create([
            'tenant_id' => $tenant2->id,
            'nama_produk' => 'Aplikasi Kasir Pro',
            'detail_produk' => 'Aplikasi kasir berbasis cloud untuk UMKM.',
            'harga' => '150000',
        ]);

        Proposal::create([
            'tenant_id' => $tenant2->id,
            'judul_proposal' => 'Pendanaan Server Skala Besar',
            'file_dokumen' => 'proposal_tech_dev.pdf',
            'status' => 'disetujui', // Contoh yang sudah disetujui
            'tanggal_pengajuan' => now()->subDays(10), // Diajukan 10 hari yang lalu
            'tanggal_persetujuan' => now()->subDays(2),
        ]);

        AnggotaTim::create([
            'tenant_id' => $tenant2->id,
            'nama_anggota' => 'Andi Wijaya',
            'nim' => '18002222',
            'prodi' => 'Ilmu Komputer',
        ]);
    }
}
