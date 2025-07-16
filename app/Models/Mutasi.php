<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $produk_lokasi_id
 * @property int|null $lokasi_asal_id
 * @property int|null $lokasi_tujuan_id
 * @property string $tanggal
 * @property string $jenis_mutasi
 * @property int $jumlah
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Database\Factories\MutasiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereJenisMutasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereLokasiAsalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereLokasiTujuanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereProdukLokasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mutasi whereUserId($value)
 * @mixin \Eloquent
 */
class Mutasi extends Model
{
    /** @use HasFactory<\Database\Factories\MutasiFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'produk_lokasi_id',
        'lokasi_asal_id',
        'lokasi_tujuan_id',
        'tanggal',
        'jenis_mutasi',
        'jumlah',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah' => 'integer'
    ];

    const JENIS_MUTASI = [
        'MASUK' => 'MASUK',
        'KELUAR' => 'KELUAR',
        'TRANSFER' => 'TRANSFER'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class);
    }

    public function lokasiAsal()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_asal_id');
    }

    public function lokasiTujuan()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_tujuan_id');
    }

    public function produk()
    {
        return $this->hasOneThrough(
            Produk::class,
            ProdukLokasi::class,
            'id',
            'id',
            'produk_lokasi_id',
            'produk_id'
        );
    }
}
