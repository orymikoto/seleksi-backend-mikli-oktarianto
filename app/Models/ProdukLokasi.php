<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukLokasiFactory> */
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'lokasi_id',
        'stok'
    ];
    
    protected $casts = [
        'stok' => 'integer'
    ];
    
    // If you need timestamps
    public $timestamps = false;
    
    // Relationships if needed
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
