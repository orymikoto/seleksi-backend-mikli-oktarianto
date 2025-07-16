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
        $units = ['PCS', 'BOX', 'KG', 'LITER', 'METER', 'ROLL', 'SET'];

        return [
            'kode_produk' => 'PRD-' . $this->faker->unique()->numberBetween(1000000, 9999999),
            'kategori_id' => Kategori::factory(),
            'nama_produk' => $this->faker->words(3, true),
            'harga' => $this->faker->numberBetween(10, 1000) * 1000,
            'satuan' => $this->faker->randomElement($units),
            'deskripsi' => $this->faker->paragraph,
            'gambar' => $this->faker->imageUrl(600, 400, 'products', true),
        ];
    }
}
