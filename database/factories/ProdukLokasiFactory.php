<?php

namespace Database\Factories;

use App\Models\Lokasi;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProdukLokasi>
 */
class ProdukLokasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produk_id' => Produk::factory(),
            'lokasi_id' => Lokasi::factory(),
            'stok' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
