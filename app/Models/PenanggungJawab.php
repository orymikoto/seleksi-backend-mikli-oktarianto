<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $no_hp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PenanggungJawabFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungJawab whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PenanggungJawab extends Model
{
    /** @use HasFactory<\Database\Factories\PenanggungJawabFactory> */
    use HasFactory;
}
