<?php

namespace Database\Seeders;

use App\Models\AnggotaTim;
use App\Models\Produk;
use App\Models\Proposal;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat 25 User Tenant
        User::factory(25)->create([
            'role' => 'tenant',
            'password' => Hash::make('password123'),
        ])->each(function ($user) {
            // 2. Untuk setiap User, buat 1 Tenant
            $tenant = Tenant::factory()->create([
                'user_id' => $user->id,
            ]);

            // 3. Buat 1 Proposal untuk Tenant tersebut
            Proposal::factory()->create([
                'tenant_id' => $tenant->id,
            ]);

            // 4. Buat 1-3 Anggota Tim
            AnggotaTim::factory(rand(1, 3))->create([
                'tenant_id' => $tenant->id,
            ]);

            // 5. Buat 1-2 Produk
            Produk::factory(rand(1, 2))->create([
                'tenant_id' => $tenant->id,
            ]);
        });
    }
}
