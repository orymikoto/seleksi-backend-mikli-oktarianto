<?php

namespace Database\Seeders;

use App\Models\Mutasi;
use App\Models\ProdukLokasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use the correct table names
        $produkLokasiTable = 'produk_lokasi';
        $mutasiTable = 'mutasis';

        // Skip if no produk_lokasi records exist
        if (DB::table($produkLokasiTable)->count() === 0) {
            $this->command->info('Skipping MutasiSeeder - no produk_lokasi records found. Seed produk and lokasi first.');
            return;
        }

        // Clear existing data
        Schema::disableForeignKeyConstraints();
        DB::table($mutasiTable)->truncate();
        Schema::enableForeignKeyConstraints();

        $users = User::all();
        
        // Get produk_lokasi records with their relationships
        $produkLokasis = DB::table($produkLokasiTable)
            ->join('produks', 'produk_lokasi.produk_id', '=', 'produks.id')
            ->join('lokasis', 'produk_lokasi.lokasi_id', '=', 'lokasis.id')
            ->select(
                'produk_lokasi.id',
                'produk_lokasi.produk_id',
                'produk_lokasi.lokasi_id',
                'produk_lokasi.stok',
                'produks.nama_produk',
                'lokasis.nama_lokasi'
            )
            ->get();

        $mutasiTypes = ['MASUK', 'KELUAR', 'TRANSFER'];
        $startDate = now()->subMonths(3);
        $endDate = now();

        // Create regular mutations (MASUK/KELUAR)
        foreach (range(1, 50) as $i) {
            $produkLokasi = $produkLokasis->random();
            $type = $mutasiTypes[array_rand([0, 1])]; // Only MASUK or KELUAR
            
            DB::table($mutasiTable)->insert([
                'user_id' => $users->random()->id,
                'produk_lokasi_id' => $produkLokasi->id,
                'lokasi_asal_id' => $type === 'KELUAR' ? $produkLokasi->lokasi_id : null,
                'lokasi_tujuan_id' => $type === 'MASUK' ? $produkLokasi->lokasi_id : null,
                'tanggal' => $this->randomDate($startDate, $endDate),
                'jenis_mutasi' => $type,
                'jumlah' => rand(1, 100),
                'keterangan' => $this->getKeterangan($type, $produkLokasi),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create transfer mutations between locations with same product
        $createdTransfers = 0;
        $maxAttempts = 50; // Prevent infinite loops
        
        while ($createdTransfers < 20 && $maxAttempts-- > 0) {
            $source = $produkLokasis->random();
            
            // Find a destination with same product but different location
            $destination = $produkLokasis->first(function ($pl) use ($source) {
                return $pl->produk_id === $source->produk_id && 
                       $pl->lokasi_id !== $source->lokasi_id;
            });

            if (!$destination) continue;

            $transferAmount = rand(1, min(50, $source->stok));

            DB::table($mutasiTable)->insert([
                'user_id' => $users->random()->id,
                'produk_lokasi_id' => $source->id,
                'lokasi_asal_id' => $source->lokasi_id,
                'lokasi_tujuan_id' => $destination->lokasi_id,
                'tanggal' => $this->randomDate($startDate, $endDate),
                'jenis_mutasi' => 'TRANSFER',
                'jumlah' => $transferAmount,
                'keterangan' => sprintf(
                    'Transfer stok dari %s ke %s',
                    $source->nama_lokasi,
                    $destination->nama_lokasi
                ),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $createdTransfers++;
        }

        $this->command->info(sprintf(
            'Seeded %d mutasi records (%d regular, %d transfers)',
            DB::table($mutasiTable)->count(),
            50,
            $createdTransfers
        ));
    }

    private function getKeterangan(string $type, object $produkLokasi): string
    {
        return match ($type) {
            'MASUK' => sprintf(
                'Penerimaan %s di %s dari %s',
                $produkLokasi->nama_produk,
                $produkLokasi->nama_lokasi,
                fake()->company()
            ),
            'KELUAR' => sprintf(
                'Pengeluaran %s dari %s untuk %s',
                $produkLokasi->nama_produk,
                $produkLokasi->nama_lokasi,
                fake()->name()
            ),
            default => 'Mutasi stok'
        };
    }

    private function randomDate($startDate, $endDate)
    {
        $randomTimestamp = mt_rand($startDate->timestamp, $endDate->timestamp);
        return \Carbon\Carbon::createFromTimestamp($randomTimestamp);
    }
}