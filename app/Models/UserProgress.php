<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserProgress
 *
 * @property int $id
 * @property int $progress_id
 * @property int $user_id
 * @property int|null $progress_quality
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProgress whereProgressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProgress whereProgressQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserProgress whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|UserProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProgress query()
 */
class UserProgress extends Model
{
    protected $table = 'user_progress';
    protected $fillable = ['progress_id','user_id','progress_quality','experience','description','gift'];
    
}
