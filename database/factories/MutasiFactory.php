<?php

namespace Database\Factories;

use App\Models\ProdukLokasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mutasi>
 */
class MutasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'produk_lokasi_id' => ProdukLokasi::factory(),
            'lokasi_asal_id' => null,
            'lokasi_tujuan_id' => null,
            'tanggal' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'jenis_mutasi' => $this->faker->randomElement(['MASUK', 'KELUAR']),
            'jumlah' => $this->faker->numberBetween(1, 100),
            'keterangan' => $this->faker->sentence,
        ];
    }

    public function transfer(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'jenis_mutasi' => 'TRANSFER',
                'lokasi_asal_id' => \App\Models\Lokasi::factory(),
                'lokasi_tujuan_id' => \App\Models\Lokasi::factory(),
            ];
        });
    }
}
