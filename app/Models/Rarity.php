<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rarity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rarity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rarity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rarity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rarity whereType($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Rarity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rarity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rarity query()
 */
class Rarity extends Model
{
    public $timestamps = false;
    protected $table = 'rarity';
    protected $fillable = ['name', 'description', 'type'];
}
