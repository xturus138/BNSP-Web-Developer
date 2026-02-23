<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_tenant' => $this->faker->company().' '.$this->faker->randomElement(['Tech', 'Solutions', 'Cafe', 'Kopi', 'Digital', 'Creative']),
            'deskripsi_singkat' => $this->faker->sentence(10),
            'no_hp_usaha' => $this->faker->phoneNumber(),
            'alamat_usaha' => $this->faker->address(),
            'media_sosial' => '@'.$this->faker->userName(),
        ];
    }
}
