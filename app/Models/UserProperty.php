<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserProperty
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $attack
 * @property int|null $damage
 * @property int|null $shield
 * @property int|null $hp
 * @property int|null $hp_current
 * @property int|null $mp
 * @property int|null $mp_current
 * @property int|null $energy
 * @property int|null $critical_damage
 * @property float|null $critical_chance
 * @property int|null $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereAttack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereCriticalChance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereCriticalDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereEnergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereHpCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereMp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereMpCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereShield($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $damage_min
 * @property int|null $damage_max
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereDamageMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProperty whereDamageMin($value)
 */
class UserProperty extends Model
{
    protected $table = 'user_properties';
    protected $fillable = ['user_id', 'attack', 'shield', 'damage_min', 'damage_max', 'hp', 'mp', 'energy', 'critical_damage', 'critical_chance', 'type_id'];
}
