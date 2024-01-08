<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Battle
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $monster_id
 * @property int|null $mission_id
 * @property int|null $count_tasks
 * @property int|null $win
 * @property int|null $current_time
 * @property int|null $battle_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Action[] $actions
 * @property-read int|null $actions_count
 * @property-read Monster|null $monster
 * @property-read User|null $user
 * @method static Builder|Battle newModelQuery()
 * @method static Builder|Battle newQuery()
 * @method static Builder|Battle query()
 * @method static Builder|Battle whereBattleTime($value)
 * @method static Builder|Battle whereCountTasks($value)
 * @method static Builder|Battle whereCreatedAt($value)
 * @method static Builder|Battle whereCurrentTime($value)
 * @method static Builder|Battle whereId($value)
 * @method static Builder|Battle whereMissionId($value)
 * @method static Builder|Battle whereMonsterId($value)
 * @method static Builder|Battle whereUpdatedAt($value)
 * @method static Builder|Battle whereUserId($value)
 * @method static Builder|Battle whereWin($value)
 * @mixin \Eloquent
 */
class Battle extends Model
{
    use PivotEventTrait;

    protected $table = 'battles';
    protected $fillable = ['user_id', 'unique_id', 'mission_id', 'win', 'number_of_moves'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    /**
     * A user may have multiple roles.
     *
     * @return BelongsToMany
     */
    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'battle_action');
    }
}
