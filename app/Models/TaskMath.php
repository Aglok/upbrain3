<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mission[] $missions
 * @property-read \App\Models\SectionsMath|null $section
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SetOfTaskMath[] $setOfTask
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereNumberTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereOriginalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskMath withSetOfTask($set_of_task_id)
 * @mixin \Eloquent
 */
class TaskMath extends Model
{

    public $timestamps = false;

    protected $table = 'tasks_math';
    protected $fillable = ['number_task','task', 'image', 'experience', 'gold', 'grade', 'answer', 'detail', 'section_id', 'set_of_task_id', 'original_number', 'book'];

    public function section()
    {
        return $this->belongsTo(SectionsMath::class);
    }

    public function setOfTask()
    {
        return $this->belongsToMany(SetOfTaskMath::class, 'set_of_task_math','task_id', 'set_of_task_id');
    }

    /**
     * Получить миссию связанную с задачей.
     */
    public function mission()
    {
        return $this->morphToMany(Mission::class,'mission', 'mission_tasks', 'task_id','mission_id');
    }

    /**
     * @param $query
     * @param $set_of_task_id
     *
     */
    public function scopeWithSetOfTask($query, $set_of_task_id)
    {
        $query->where('set_of_task_id', $set_of_task_id);
    }
}
