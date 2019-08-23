<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TrophyType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrophyType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrophyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrophyType whereName($value)
 * @mixin \Eloquent
 */
class TrophyType extends Model
{
    public $timestamps = false;

    protected $table = 'trophy_type';
    protected $fillable = ['name', 'description'];

    public static function getList()
    {

        return static::lists('name', 'id')->toArray();
    }
}
