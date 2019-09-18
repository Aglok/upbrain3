<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArtifactType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $dir
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtifactType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtifactType whereDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtifactType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtifactType whereName($value)
 * @mixin \Eloquent
 */
class ArtifactType extends Model
{
    public $timestamps = false;

    protected $table = 'artifact_type';
    protected $fillable = ['name', 'description', 'dir'];
    
}
