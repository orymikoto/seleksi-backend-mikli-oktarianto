<?php

use App\Models\PenanggungJawab;
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
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignIdFor(PenanggungJawab::class);

            $table->string('kode_lokasi')->unique();
            $table->string('nama_lokasi');
            $table->text('alamat_lengkap')->nullable();
            $table->string('x_coordinate')->nullable();
            $table->string('y_coordinate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasis');
    }
};
