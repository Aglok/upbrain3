<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArtifactType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $dir
 * @method static Builder|ArtifactType whereDescription($value)
 * @method static Builder|ArtifactType whereDir($value)
 * @method static Builder|ArtifactType whereId($value)
 * @method static Builder|ArtifactType whereName($value)
 * @mixin \Eloquent
 * @property int|null $slot_id
 * @property int|null $active
 * @method static Builder|ArtifactType newModelQuery()
 * @method static Builder|ArtifactType newQuery()
 * @method static Builder|ArtifactType query()
 * @method static Builder|ArtifactType whereActive($value)
 * @method static Builder|ArtifactType whereSlotId($value)
 */
class ArtifactType extends Model
{
    public $timestamps = false;

    protected $table = 'artifact_type';
    protected $fillable = ['name', 'description', 'dir', 'slot_id', 'active'];
    
}
