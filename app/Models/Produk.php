<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;

    public function lokasis()
    {
        return $this->belongsToMany(Produk::class, 'produk_lokasi')
                ->using(ProdukLokasi::class)
                ->withPivot('stok');
    }
     
}
