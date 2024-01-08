<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Trophy
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $image
 * @property int|null $type
 * @property int|null $attack
 * @property int|null $defense
 * @property int|null $magic
 * @property int|null $energy
 * @property float|null $experience
 * @property float|null $gold
 * @property int|null $rarity_id
 * @property float|null $weight
 * @property int|null $user_level
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereAttack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereDefense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereEnergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereMagic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereRarityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereUserLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trophy whereWeight($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Trophy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trophy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trophy query()
 */
class Trophy extends Model
{

    public $timestamps = false;

    protected $table = 'trophies';
    protected $fillable = ['name', 'description', 'image', 'type', 'attack', 'defense', 'magic', 'energy', 'experience', 'gold', 'rarity_id', 'weight', 'user_level'];

    public function getImageFields()
    {
        return [
            //В конце пути обязательно '/'
            'image' => ['items/trophy/', function ($directory, $originalName, $extension) {
                //выводит оригинальное название рисунка. По умолчанию название рисунков random
                return $originalName;
            }]
        ];
    }

    /**
     * @return string
     */
    public static function getlist()
    {
        return static::lists('name', 'id')->toArray();
    }
}
