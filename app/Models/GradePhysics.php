<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GradePhysics
 *
 * @property int $id
 * @property int|null $section_id
 * @property int|null $user_id
 * @property int|null $sum_tasks
 * @property string|null $grade_char
 * @property float|null $sum_exp
 * @property float|null $sum_gold
 * @property int|null $number_lesson
 * @property int|null $time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereGradeChar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereNumberLesson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereSumExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereSumGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereSumTasks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradePhysics whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $sum_crystal
 * @method static \Illuminate\Database\Eloquent\Builder|GradePhysics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GradePhysics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GradePhysics query()
 * @method static \Illuminate\Database\Eloquent\Builder|GradePhysics whereSumCrystal($value)
 */
class GradePhysics extends Model
{
    protected $table = 'grade_physics';
    protected $fillable = ['subject_id', 'user_id', 'grade_char', 'sum_tasks', 'full', 'time', 'number_lesson', 'sum_exp', 'sum_gold', 'created_at', 'updated_at'];
}
