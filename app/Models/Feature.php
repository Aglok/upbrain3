<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Feature
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $image
 * @property int|null $upgrade
 * @property float|null $value
 * @property string|null $description
 * @property string|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artifact[] $artifacts
 * @property-read int|null $artifacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Monster[] $monsters
 * @property-read int|null $monsters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $skills
 * @property-read int|null $skills_count
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpgrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereValue($value)
 * @mixin \Eloquent
 */
class Feature extends Model
{
    public $timestamps = false;
    protected $table = 'features';
    protected $fillable = ['title', 'image', 'upgrade', 'value', 'description', 'type', 'modification'];

    public function artifacts(){
        return $this->morphedByMany(Artifact::class, 'entity', 'feature_entity')->withPivot('done');
    }

    public function skills(){
        return $this->morphedByMany(Skill::class, 'entity', 'feature_entity');
    }

    public function monsters(){
        return $this->morphedByMany(Monster::class, 'entity', 'feature_entity');
    }
}
