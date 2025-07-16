<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProdukLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use the correct table name (produk_lokasi instead of produk_lokasis)
        $tableName = 'produk_lokasi';

        // Skip if no products or locations exist
        if (Produk::count() === 0 || Lokasi::count() === 0) {
            $this->command->info('Skipping ProdukLokasiSeeder - no products or locations found. Seed produk and lokasi first.');
            return;
        }

        $this->command->info('Seeding produk-lokasi relationships with initial stock...');

        // Clear existing data
        Schema::disableForeignKeyConstraints();
        DB::table($tableName)->truncate();
        Schema::enableForeignKeyConstraints();

        $produks = Produk::all();
        $lokasis = Lokasi::all();
        $totalRelationships = 0;

        // For each location, assign random products with initial stock
        foreach ($lokasis as $lokasi) {
            // Get 1-5 random products (but not more than total products)
            $productCount = rand(1, min(5, $produks->count()));
            $randomProduks = $produks->random($productCount);

            foreach ($randomProduks as $produk) {
                $initialStock = rand(10, 100);
                
                DB::table($tableName)->insert([
                    'produk_id' => $produk->id,
                    'lokasi_id' => $lokasi->id,
                    'stok' => $initialStock,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info(sprintf(
                    'Assigned product %s to location %s with initial stock %d',
                    $produk->nama_produk,
                    $lokasi->nama_lokasi,
                    $initialStock
                ));

                $totalRelationships++;
            }
        }

        $this->command->info(sprintf(
            'Successfully created %d produk-lokasi relationships',
            $totalRelationships
        ));
    }
}