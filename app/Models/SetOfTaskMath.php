<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SetOfTaskMath
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaskMath[] $tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskMath whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SetOfTaskMath extends Model
{

    protected $table = 'set_of_tasks_math';
    protected $fillable = ['id','name','alias','image','type','description','created_at','updated_at'];

    public function set_of_task_type(){
        return $this->belongsTo(SetOfTaskType::class, 'type');
    }

    public function tasks(){
        return $this->belongsToMany(TaskMath::class, 'set_of_task_math','set_of_task_id', 'task_id');
    }
}
