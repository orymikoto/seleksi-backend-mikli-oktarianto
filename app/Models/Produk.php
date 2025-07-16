<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $kode_produk
 * @property int|null $kategori_id
 * @property string $nama_produk
 * @property string $harga
 * @property string|null $deskripsi
 * @property string $satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $gambar
 * @property-read \App\Models\Kategori|null $kategori
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lokasi> $lokasis
 * @property-read int|null $lokasis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mutasi> $mutasis
 * @property-read int|null $mutasis_count
 * @method static \Database\Factories\ProdukFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereKodeProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereNamaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produk whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_produk',
        'kategori_id',
        'nama_produk',
        'harga',
        'deskripsi',
        'satuan',
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasi')
            ->withPivot('stok')
            ->withTimestamps();
    }

    public function mutasis()
    {
        return $this->hasManyThrough(
            Mutasi::class,
            ProdukLokasi::class,
            'produk_id',
            'produk_lokasi_id'
        );
    }
     
}
