<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $alias
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereName($value)
 * @mixin \Eloquent
 * @property string|null $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Artifact[] $artifacts
 * @property-read int|null $artifacts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereColor($value)
 */
class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = ['name','alias','color'];

    /**
     * Получить артефакты, которые принадлежат предмету.
     */
    public function artifacts(): BelongsToMany
    {
        return $this->belongsToMany(Artifact::class);
    }
}
