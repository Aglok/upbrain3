<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProcessPhysics
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereNumberLesson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereNumberTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProcessPhysics whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $crystal
 * @property int|null $done
 * @property-read \App\Models\Stage|null $stage
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessPhysics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessPhysics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessPhysics query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessPhysics whereCrystal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessPhysics whereDone($value)
 */
class ProcessPhysics extends Model
{
    protected $table = 'processes_physics';
    protected $fillable = ['user_id', 'number_task', 'stage_id', 'experience', 'gold', 'rating', 'comment', 'number_lesson', 'done'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function stage()
    {
        return $this->belongsTo(\App\Models\Stage::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Models\TaskMath::class,  'number_task');
    }
}
