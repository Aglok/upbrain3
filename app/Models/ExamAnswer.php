<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExamAnswer
 *
 * @property int $id
 * @property int $exam_id
 * @property string $exam_answers
 * @property-read \App\Models\Exam $exam
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamAnswer whereExamAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamAnswer whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamAnswer whereId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamAnswer query()
 */
class ExamAnswer extends Model
{
    public $timestamps = false;
    protected $table = 'exam_answers';
    protected $fillable = ['exam_id', 'answers'];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
