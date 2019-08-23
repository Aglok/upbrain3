<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTrophy
 *
 * @property int $id
 * @property int|null $trophy_id
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserTrophy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserTrophy whereTrophyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserTrophy whereUserId($value)
 * @mixin \Eloquent
 */
class UserTrophy extends Model
{
    public $timestamps = false;

    protected $table = 'user_trophy';
    protected $fillable = ['trophy_id', 'user_id'];
}
