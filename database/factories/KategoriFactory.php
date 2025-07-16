<?php

namespace Database\Factories;

use App\Models\Satuan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Elektronik', 'Fashion', 'Makanan', 'Minuman', 'Alat Rumah Tangga',
            'Kesehatan', 'Kecantikan', 'Olahraga', 'Mainan', 'Buku',
            'Otomotif', 'Perkakas', 'Peralatan Kantor', 'Hobi', 'Aksesoris'
        ];

        return [
            'nama_kategori' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
