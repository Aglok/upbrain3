<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaskPhysics
 *
 * @property int $id
 * @property int|null $number_task
 * @property string|null $task
 * @property string|null $image_1
 * @property string|null $image_2
 * @property string|null $image_1_answer
 * @property string|null $image_2_answer
 * @property int|null $experience
 * @property int|null $gold
 * @property string|null $grade
 * @property int|null $section_id
 * @property string|null $answer
 * @property string|null $detail
 * @property string|null $original_number
 * @property string|null $book
 * @property-read \App\Models\SectionsPhysics|null $section
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereBook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereImage1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereImage1Answer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereImage2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereImage2Answer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereNumberTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereOriginalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskPhysics whereTask($value)
 * @mixin \Eloquent
 * @property int|null $crystal
 * @property int|null $verifiable
 * @property-read Model|\Eloquent $mission
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPhysics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPhysics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPhysics query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPhysics whereCrystal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPhysics whereVerifiable($value)
 */
class TaskPhysics extends Model
{

    public $timestamps = false;

    protected $table = 'tasks_physics';
    protected $fillable = ['number_task', 'task', 'image_a' , 'image_b' ,'experience', 'gold', 'grade', 'answer', 'verifiable' ,'detail', 'section_id', 'set_of_task_id', 'original_number', 'book'];

    public function section()
    {
        return $this->belongsTo(SectionsPhysics::class);
    }

    /**
     * Получить миссию связанную с задачей.
     */
    public function mission()
    {
        return $this->morphTo();
    }
}
