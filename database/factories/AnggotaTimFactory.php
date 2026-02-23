<?php

namespace Database\Factories;

use App\Models\AnggotaTim;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnggotaTimFactory extends Factory
{
    protected $model = AnggotaTim::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'nama_anggota' => $this->faker->name(),
            'nim' => $this->faker->numerify('1900####'),
            'prodi' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'DKV']),
            'fakultas' => 'Fakultas Teknologi Informasi',
        ];
    }
}
