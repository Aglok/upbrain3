<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MonsterType
 *
 * @property int $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|MonsterType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonsterType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MonsterType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MonsterType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MonsterType whereName($value)
 * @mixin \Eloquent
 */
class MonsterType extends Model
{
    public $timestamps = false;

    protected $table = 'monster_type';
    protected $fillable = ['name'];
}
