<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property-read \App\Models\Lokasi|null $lokasi
 * @property-read \App\Models\Produk|null $produk
 * @method static \Database\Factories\ProdukLokasiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukLokasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukLokasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProdukLokasi query()
 * @mixin \Eloquent
 */
class ProdukLokasi extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukLokasiFactory> */
    use HasFactory;

    protected $table = 'produk_lokasi';

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
