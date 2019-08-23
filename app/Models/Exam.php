<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Exam
 *
 * @property int $id
 * @property int $exam_subject_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $start_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\ExamSubject $exam_subject
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereExamSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = ['exam_subject_id', 'name', 'description', 'type', 'date'];

    public function exam_subject(){
        return $this->belongsTo(ExamSubject::class, 'exam_subject_id', 'id');
    }
}
