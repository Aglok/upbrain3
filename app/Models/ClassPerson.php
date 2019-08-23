<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassPerson
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $attack
 * @property int|null $defense
 * @property int|null $magic
 * @property int|null $energy
 * @property int|null $health_point
 * @property float|null $increase_experience
 * @property float|null $increase_gold
 * @property int|null $skill_1_id
 * @property int|null $skill_2_id
 * @property int|null $skill_3_id
 * @property string|null $icon_man
 * @property string|null $icon_woman
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereAttack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereDefense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereEnergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereHealthPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereIconMan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereIconWoman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereIncreaseExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereIncreaseGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereMagic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereSkill1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereSkill2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClassPerson whereSkill3Id($value)
 * @mixin \Eloquent
 */
class ClassPerson extends Model
{
    public $timestamps = false;

    protected $table = 'classes_person';
    protected $fillable = ['name', 'description', 'attack', 'defense', 'magic', 'energy', 'health_point', 'increase_experience', 'increase_gold', 'skill_1_id', 'skill_2_id', 'skill_3_id', 'icon_man', 'icon_woman'];
    
}
