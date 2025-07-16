<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SatuanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Satuan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Satuan extends Model
{
    /** @use HasFactory<\Database\Factories\SatuanFactory> */
    use HasFactory;
}
