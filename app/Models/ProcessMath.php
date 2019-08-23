<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProcessMath
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $stage_id
 * @property int|null $number_task
 * @property float|null $experience
 * @property float|null $gold
 * @property string|null $rating
 * @property string|null $comment
 * @property int|null $number_lesson
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereNumberLesson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereNumberTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessMath whereUserId($value)
 * @mixin \Eloquent
 */
class ProcessMath extends Model
{
    protected $table = 'processes_math';
    protected $fillable = ['user_id', 'number_task', 'stage_id', 'experience', 'gold', 'rating', 'comment', 'number_lesson'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
