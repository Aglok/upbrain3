<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SetOfTaskPhysics
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property int $type
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\SetOfTaskType $set_of_task_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SetOfTaskPhysics[] $tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskPhysics whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SetOfTaskPhysics extends Model
{
    protected $table = 'set_of_tasks_physics';
    protected $fillable = ['name', 'alias', 'image', 'type', 'description', 'created_at', 'updated_at'];

    public function set_of_task_type(){
        return $this->belongsTo(SetOfTaskType::class, 'type');
    }

    public function tasks(){
        return $this->belongsToMany(SetOfTaskPhysics::class, 'set_of_task_physics','set_of_task_id');
    }
}
