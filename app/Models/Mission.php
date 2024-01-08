<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Mission
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Mission whereCondition($value)
 * @method static Builder|Mission whereCreatedAt($value)
 * @method static Builder|Mission whereDescription($value)
 * @method static Builder|Mission whereId($value)
 * @method static Builder|Mission whereListArtifactsId($value)
 * @method static Builder|Mission whereListTasksId($value)
 * @method static Builder|Mission whereName($value)
 * @method static Builder|Mission whereSetOfTasksId($value)
 * @method static Builder|Mission whereUpdatedAt($value)
 * @method static Builder|Mission whereUserLevel($value)
 * @mixin Eloquent
 * @property int|null $progress_id
 * @property int|null $subject_id
 * @property int|null $level
 * @method static Builder|Mission whereLevel($value)
 * @method static Builder|Mission whereProgressId($value)
 * @method static Builder|Mission whereSubjectId($value)
 * @property int|null $monster_id
 * @property int|null $user_level
 * @property-read Collection|Artifact[] $artifacts
 * @property-read int|null $artifacts_count
 * @property-read Monster|null $monster
 * @property-read Progress|null $progress
 * @property-read Collection|TaskMath[] $task_math
 * @property-read int|null $task_math_count
 * @property-read Collection|TaskPhysics[] $task_physics
 * @property-read int|null $task_physics_count
 * @method static Builder|Mission newModelQuery()
 * @method static Builder|Mission newQuery()
 * @method static Builder|Mission query()
 * @method static Builder|Mission whereMonsterId($value)
 */
class Mission extends Model
{
    protected $table = 'missions';
    protected $fillable = ['name', 'description', 'subject_id', 'progress_id', 'user_level'];


    /**
     * Получить задачи модели математики связанные с одной миссией.
     */
    public function task_math(): MorphToMany
    {
        return $this->morphedByMany(TaskMath::class, 'mission', 'mission_tasks','mission_id','task_id')->withPivot(['percent', 'done']);
    }

    /**
     * Получить задачи модели физики связанные с одной миссией.
     */
    public function task_physics(): MorphToMany
    {
        return $this->morphedByMany(TaskPhysics::class, 'mission', 'mission_tasks','mission_id','task_id')->withPivot(['percent', 'done']);
    }

    /**
     * Получить все артефакты, связанные с квестом.
     */
    public function artifacts(): BelongsToMany
    {
        return $this->belongsToMany(Artifact::class, 'mission_artifact');
    }

    /**
     * Получить все достижения по предмету, связанные с квестом.
     * Если достижение включает в себя несколько достижений, то выводить всю цепочку подкатегорий
     */
    public function progress(): HasOne
    {
        return $this->hasOne(Progress::class);
    }

    /**
     * Получить монстра, связанного с квестом.
     */
    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }
}
