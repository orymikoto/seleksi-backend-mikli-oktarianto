<?php

namespace Database\Factories;

use App\Models\PenanggungJawab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lokasi>
 */
class LokasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_lokasi' => 'LOC-' . $this->faker->unique()->numberBetween(100, 999),
            'penanggung_jawab_id' => PenanggungJawab::factory(),
            'nama_lokasi' => $this->faker->city . ' Warehouse',
            'alamat_lengkap' => $this->faker->address,
            'x_coordinate' => $this->faker->latitude,
            'y_coordinate' => $this->faker->longitude,
        ];
    }
}
