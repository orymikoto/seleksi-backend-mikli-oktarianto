<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();

            // Required Relations
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignId('produk_lokasi_id')->constrained('produk_lokasi');

            // Relations For transfer mutations
            $table->foreignId('lokasi_asal_id')->nullable()->constrained('lokasis');
            $table->foreignId('lokasi_tujuan_id')->nullable()->constrained('lokasis');

            $table->dateTime('tanggal');
            $table->enum('jenis_mutasi', ['MASUK', 'KELUAR']);
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
