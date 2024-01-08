<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Monster
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $monster_type_id
 * @property string|null $image
 * @property int|null $attack
 * @property int|null $damage
 * @property int|null $critical_damage
 * @property float|null $critical_chance
 * @property int|null $shield
 * @property int|null $hp
 * @property int|null $mp
 * @property int|null $energy
 * @property int|null $monster_level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feature[] $features
 * @property-read int|null $features_count
 * @property-read \App\Models\MonsterType|null $monster_type
 * @method static \Illuminate\Database\Eloquent\Builder|Monster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monster query()
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereAttack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereCriticalChance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereCriticalDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereEnergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereMonsterLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereMonsterTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereMp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereShield($value)
 * @mixin \Eloquent
 * @property int|null $damage_min
 * @property int|null $damage_max
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereDamageMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monster whereDamageMin($value)
 */
class Monster extends Model
{
    public $timestamps = false;
    protected $table = 'monsters';
    protected $fillable = ['name', 'description', 'monster_type_id', 'image', 'attack', 'damage_min', 'damage_max', 'critical_damage' ,'critical_chance' ,'shield', 'hp' ,'mp', 'energy', 'monster_level'];

    /**
     * Получить тип монстра
     */
    public function monster_type(){
        return $this->belongsTo(MonsterType::class);
    }

    /**
     * Получить расширения навыков.
     */
    public function features(){
        return $this->morphToMany(Feature::class, 'entity', 'feature_entity');
    }
}
