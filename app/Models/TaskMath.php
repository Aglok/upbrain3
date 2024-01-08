<?php namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\TaskMath
 *
 * @property int $id
 * @property int|null $number_task
 * @property string|null $task
 * @property string|null $image
 * @property int|null $experience
 * @property int|null $gold
 * @property string|null $grade
 * @property int|null $section_id
 * @property string|null $answer
 * @property string|null $detail
 * @property string|null $original_number
 * @property string|null $book
 * @property-read Collection|Mission[] $missions
 * @property-read SectionsMath|null $section
 * @property-read Collection|SetOfTaskMath[] $setOfTask
 * @method static Builder|TaskMath whereAnswer($value)
 * @method static Builder|TaskMath whereBook($value)
 * @method static Builder|TaskMath whereDetail($value)
 * @method static Builder|TaskMath whereExperience($value)
 * @method static Builder|TaskMath whereGold($value)
 * @method static Builder|TaskMath whereGrade($value)
 * @method static Builder|TaskMath whereId($value)
 * @method static Builder|TaskMath whereImage($value)
 * @method static Builder|TaskMath whereNumberTask($value)
 * @method static Builder|TaskMath whereOriginalNumber($value)
 * @method static Builder|TaskMath whereSectionId($value)
 * @method static Builder|TaskMath whereTask($value)
 * @method static Builder|TaskMath withSetOfTask($set_of_task_id)
 * @mixin Eloquent
 * @property int|null $crystal
 * @property int|null $verifiable
 * @property-read Collection|Mission[] $mission
 * @property-read int|null $mission_count
 * @property-read int|null $set_of_task_count
 * @method static Builder|TaskMath newModelQuery()
 * @method static Builder|TaskMath newQuery()
 * @method static Builder|TaskMath query()
 * @method static Builder|TaskMath whereCrystal($value)
 * @method static Builder|TaskMath whereVerifiable($value)
 */
class TaskMath extends Model
{

    public $timestamps = false;

    protected $table = 'tasks_math';
    protected $fillable = ['number_task','task', 'image', 'experience', 'gold', 'grade', 'answer', 'verifiable', 'detail', 'section_id', 'set_of_task_id', 'original_number', 'book'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(SectionsMath::class);
    }

    public function setOfTask(): BelongsToMany
    {
        return $this->belongsToMany(SetOfTaskMath::class, 'set_of_task_math','task_id', 'set_of_task_id');
    }

    /**
     * Получить миссию связанную с задачей.
     */
    public function mission(): MorphToMany
    {
        return $this->morphToMany(Mission::class,'mission', 'mission_tasks', 'task_id','mission_id');
    }

    /**
     * @param $query
     * @param int $set_of_task_id
     */
    public function scopeWithSetOfTask($query, int $set_of_task_id): void
    {
        $tasks_ids = SetOfTaskMath::find($set_of_task_id)->tasks()->get()->pluck('id');
        $query->whereIn('id', $tasks_ids);
    }

    /**
     * @param $query
     * @param int $mission_id
     */
    public function scopeWithMission($query, int $mission_id): void
    {
        //Список id задач
        $tasks_ids = Mission::find($mission_id)->task_math()->get()->pluck('id');
        $query->whereIn('id', $tasks_ids);
    }
}
