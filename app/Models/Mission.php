<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mission
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereListArtifactsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereListTasksId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereSetOfTasksId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereUserLevel($value)
 * @mixin \Eloquent
 * @property int|null $progress_id
 * @property int|null $subject_id
 * @property int|null $level
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereProgressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mission whereSubjectId($value)
 */
class Mission extends Model
{
    protected $table = 'missions';
    protected $fillable = ['name', 'description', 'subject_id', 'progress_id', 'level'];


    /**
     * Получить задачи модели математики связанные с одной миссией.
     */
    public function task_math()
    {
        return $this->morphedByMany(TaskMath::class, 'mission', 'mission_tasks','mission_id','task_id');
    }

    /**
     * Получить задачи модели физики связанные с одной миссией.
     */
    public function task_physics()
    {
        return $this->morphedByMany(TaskPhysics::class, 'mission', 'mission_tasks','mission_id','task_id');
    }

    /**
     * Получить все артефакты, связанные с квестом.
     */
    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class);
    }

    /**
     * Получить все достижения по предмету, связанные с квестом.
     * Если достижение включает в себя несколько достижений, то выводить всю цепочку подкатегорий
     */
    public function progress()
    {
        return $this->hasOne(Progress::class);
    }
}
