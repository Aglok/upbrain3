<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\ExamResult
 *
 * @property int $id
 * @property string|null $result_short_answers
 * @property string|null $result_expanded_answers
 * @property string|null $short_answers
 * @property int|null $user_id
 * @property int|null $exam_id
 * @property string|null $images
 * @property string|null $comments
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Exam|null $exam
 * @property-read \App\Models\ExamAnswer|null $exam_answers
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereResultExpandedAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereResultShortAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereShortAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamResult whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult query()
 * @property int|null $exam_answer_id
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereExamAnswerId($value)
 */
class ExamResult extends Model
{
    protected $table = 'exam_results';
    protected $fillable = ['result_short_answers', 'result_expanded_answers', 'short_answers', 'user_id' ,'exam_id', 'comments', 'images'];

//    protected $casts = [
//        'images' => 'array'
//    ];
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam_answers(): BelongsTo
    {
        return $this->belongsTo(ExamAnswer::class, 'exam_id', 'exam_id');
    }

    public function exam_examiners(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'exam_examiners', 'exam_result_id', 'user_id');
    }
}
