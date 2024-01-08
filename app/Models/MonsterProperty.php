<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\MonsterProperty
 *
 * @property int $id
 * @property int|null $battle_id
 * @property int|null $monster_id
 * @property int|null $attack
 * @property int|null $damage
 * @property int|null $critical_damage
 * @property float|null $critical_chance
 * @property int|null $shield
 * @property int|null $hp
 * @property int|null $hp_current
 * @property int|null $mp
 * @property int|null $mp_current
 * @property int|null $energy
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|MonsterProperty newModelQuery()
 * @method static Builder|MonsterProperty newQuery()
 * @method static \Illuminate\Database\Query\Builder|MonsterProperty onlyTrashed()
 * @method static Builder|MonsterProperty query()
 * @method static Builder|MonsterProperty whereAttack($value)
 * @method static Builder|MonsterProperty whereBattleId($value)
 * @method static Builder|MonsterProperty whereCreatedAt($value)
 * @method static Builder|MonsterProperty whereCriticalChance($value)
 * @method static Builder|MonsterProperty whereCriticalDamage($value)
 * @method static Builder|MonsterProperty whereDamage($value)
 * @method static Builder|MonsterProperty whereDeletedAt($value)
 * @method static Builder|MonsterProperty whereEnergy($value)
 * @method static Builder|MonsterProperty whereHp($value)
 * @method static Builder|MonsterProperty whereHpCurrent($value)
 * @method static Builder|MonsterProperty whereId($value)
 * @method static Builder|MonsterProperty whereMonsterId($value)
 * @method static Builder|MonsterProperty whereMp($value)
 * @method static Builder|MonsterProperty whereMpCurrent($value)
 * @method static Builder|MonsterProperty whereShield($value)
 * @method static Builder|MonsterProperty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|MonsterProperty withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MonsterProperty withoutTrashed()
 * @mixin \Eloquent
 */
class MonsterProperty extends Model
{
    use SoftDeletes;
    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'monster_properties';
    protected $fillable = ['battle_id', 'monster_id', 'attack', 'shield', 'damage_min', 'damage_max', 'hp', 'hp_current', 'mp', 'mp_current', 'energy', 'critical_damage', 'critical_chance'];
}
