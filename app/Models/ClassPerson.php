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
 * @property int|null $shield
 * @property int|null $damage
 * @property int|null $hp
 * @property int|null $mp
 * @property int|null $energy
 * @property int|null $critical_damage
 * @property float|null $critical_chance
 * @property string|null $image
 * @property string|null $sex
 * @property int|null $type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereAttack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereCriticalChance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereCriticalDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereEnergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereMp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereShield($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereTypeId($value)
 * @mixin \Eloquent
 * @property int|null $damage_min
 * @property int|null $damage_max
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Progress[] $progresses
 * @property-read int|null $progresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $skills
 * @property-read int|null $skills_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $subjects
 * @property-read int|null $subjects_count
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereDamageMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassPerson whereDamageMin($value)
 */
class ClassPerson extends Model
{
    public $timestamps = false;
    /**
     *
     * @var array
     */
    protected $touches = ['users'];

    protected $table = 'classes_person';
    protected $fillable = ['name', 'description', 'attack', 'shield', 'damage_min', 'damage_max', 'hp', 'mp', 'energy', 'critical_damage', 'critical_chance', 'image', 'sex', 'type_id'];

    /**
     * A user may have multiple classes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'user_class');
    }
    /**
     * Получить все скиллы класса
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(\App\Models\Skill::class, 'class_person_skill', '');
    }
    /**
     * Получить предметы, которые наделяют условием чтобы получить образ.
     */
    public function subjects(){
        return $this->belongsToMany(Subject::class)->withPivot('user_level');
    }
    /**
     * Получить достижения, которые наделяют условием чтобы получить образ.
     */
    public function progresses(){
        return $this->belongsToMany(Progress::class);
    }

}
