<?php

namespace App\Observers;

use App\Models\Battle;
use App\Models\UserMission;
use App\Models\Mission;

class UserMissionObserver
{
    /**
     * Handle the UserMission "created" event.
     *
     * @param  \App\Models\UserMission  $userMission
     * @return void
     */
    public function created(UserMission $userMission)
    {
        $monster_id = Mission::whereId($userMission->mission_id)->value('monster_id');

        Battle::create([
            'user_id' => $userMission->user_id,
            'mission_id' => $userMission->mission_id,
            'monster_id' =>  $monster_id,
            'count_tasks' => 0,
            'current_time' => 0
        ]);
    }

    /**
     * Handle the UserMission "updated" event.
     *
     * @param  \App\Models\UserMission  $userMission
     * @return void
     */
    public function updated(UserMission $userMission)
    {
        //
    }

    /**
     * Handle the UserMission "deleted" event.
     *
     * @param  \App\Models\UserMission  $userMission
     * @return void
     */
    public function deleted(UserMission $userMission)
    {
        //
    }

    /**
     * Handle the UserMission "restored" event.
     *
     * @param  \App\Models\UserMission  $userMission
     * @return void
     */
    public function restored(UserMission $userMission)
    {
        //
    }

    /**
     * Handle the UserMission "force deleted" event.
     *
     * @param  \App\Models\UserMission  $userMission
     * @return void
     */
    public function forceDeleted(UserMission $userMission)
    {
        //
    }
}
