<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GradeMath
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereGradeChar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereNumberLesson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereSumExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereSumGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereSumTasks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GradeMath whereUserId($value)
 * @mixin \Eloquent
 */
class GradeMath extends Model
{
    protected $table = 'grade_math';
    protected $fillable = ['section_id', 'user_id', 'grade_char', 'sum_tasks', 'full', 'time', 'number_lesson', 'sum_exp', 'sum_gold', 'created_at', 'updated_at'];
}
