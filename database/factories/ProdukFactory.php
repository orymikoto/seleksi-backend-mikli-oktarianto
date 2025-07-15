<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_produk' => 'PRD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'kategori_id' => Kategori::factory(),
            'nama_produk' => $this->faker->words(3, true),
            'harga' => $this->faker->numberBetween(10, 1000) * 1000,
            'deskripsi' => $this->faker->paragraph,
        ];
    }
}
