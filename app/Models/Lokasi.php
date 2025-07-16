<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $penanggung_jawab_id
 * @property string $kode_lokasi
 * @property string $nama_lokasi
 * @property string|null $alamat_lengkap
 * @property string|null $x_coordinate
 * @property string|null $y_coordinate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Lokasi> $produks
 * @property-read int|null $produks_count
 * @method static \Database\Factories\LokasiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereAlamatLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereKodeLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereNamaLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi wherePenanggungJawabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereXCoordinate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lokasi whereYCoordinate($value)
 * @mixin \Eloquent
 */
class Lokasi extends Model
{
    /** @use HasFactory<\Database\Factories\LokasiFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'penanggung_jawab_id',
        'kode_lokasi',
        'nama_lokasi',
        'alamat_lengkap',
        'x_coordinate',
        'y_coordinate',
    ];
    
    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'produk_lokasi') 
            ->withPivot('stok')
            ->withTimestamps();
    }

    public function penanggungJawab(): BelongsTo
    {
        return $this->belongsTo(PenanggungJawab::class);
    }

    public function mutasiAsal()
    {
        return $this->hasMany(Mutasi::class, 'lokasi_asal_id');
    }

    public function mutasiTujuan()
    {
        return $this->hasMany(Mutasi::class, 'lokasi_tujuan_id');
    }
}
