<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SkillType
 *
 * @property int $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|SkillType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillType whereName($value)
 * @mixin \Eloquent
 */
class SkillType extends Model
{
    public $timestamps = false;

    protected $table = 'skill_type';
    protected $fillable = ['name'];
}
