<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamResult[] $exam_results
 * @property-read int|null $exam_results_count
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam query()
 */
class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = ['exam_subject_id', 'name', 'description', 'type', 'date'];

    public function exam_subject(): BelongsTo
    {
        return $this->belongsTo(ExamSubject::class, 'exam_subject_id', 'id');
    }

    public function exam_results(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    public function exam_examiners(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'exam_examiners');
    }
}
