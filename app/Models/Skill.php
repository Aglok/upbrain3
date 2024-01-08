<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Skill
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $skill_type_id
 * @property int|null $upgrade
 * @property int|null $user_level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feature[] $features
 * @property-read int|null $features_count
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereSkillTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereUpgrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereUserLevel($value)
 * @mixin \Eloquent
 * @property int|null $number_of_moves
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereNumberOfMoves($value)
 * @property int|null $active
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereActive($value)
 */
class Skill extends Model
{
    public $timestamps = false;

    protected $table = 'skills';
    protected $fillable = ['name', 'description', 'skill_type_id', 'upgrade', 'user_level', 'number_of_moves'];

    /**
     * Получить расширения навыков.
     */
    public function features(): MorphToMany
    {
        return $this->morphToMany(Feature::class, 'entity', 'feature_entity')->withPivot('target');
    }
}
