<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'nama_produk' => 'Produk '.$this->faker->word(),
            'detail_produk' => $this->faker->paragraph(),
            'harga' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
