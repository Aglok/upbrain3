<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserMission
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $mission_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $done
 * @property-read \App\Models\Mission|null $mission
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMission whereDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMission whereMissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMission whereUserId($value)
 * @mixin \Eloquent
 */
class UserMission extends Model
{
    protected $table = 'user_mission';
    protected $fillable = ['user_id','mission_id', 'created_at', 'updated_at'];

    public function mission(){
        return $this->belongsTo(Mission::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
