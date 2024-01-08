<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserMission
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $mission_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $done
 * @property-read Mission|null $mission
 * @property-read User|null $user
 * @method static Builder|UserMission whereCreatedAt($value)
 * @method static Builder|UserMission whereDone($value)
 * @method static Builder|UserMission whereId($value)
 * @method static Builder|UserMission whereMissionId($value)
 * @method static Builder|UserMission whereUpdatedAt($value)
 * @method static Builder|UserMission whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|UserMission newModelQuery()
 * @method static Builder|UserMission newQuery()
 * @method static Builder|UserMission query()
 */
class UserMission extends Model
{
    protected $table = 'user_mission';
    protected $fillable = ['user_id', 'mission_id', 'created_at', 'updated_at'];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
