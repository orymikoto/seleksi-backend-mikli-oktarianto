<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First create some categories
        $categories = Kategori::factory(15)->create();

        // Then create products with existing categories
        Produk::factory(200)
            ->create([
                'kategori_id' => function () use ($categories) {
                    return $categories->random()->id;
                }
            ]);
    }
}
