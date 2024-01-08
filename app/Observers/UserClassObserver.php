<?php

namespace App\Observers;

use App\Models\ImageOfCharacter;
use App\Models\UserClass;
use App\Models\UserBody;
use App\User;

class UserClassObserver
{
    /**
     * Handle the UserClass "created" event.
     *
     * @param UserClass $userClass
     * @return void
     */
    public function created(UserClass $userClass): void
    {
        $user_id = $userClass->user_id;
        $class_person_id = $userClass->class_person_id;

        $sex = User::find($user_id)->value('sex');
        $body = ImageOfCharacter::where( 'class_person_id', $class_person_id)->where('sex', $sex)->first();

        //Каждому классу по одному одному образу
        UserBody::create([
            'user_id'=>$user_id,
            'image_of_character_id'=> $body->id,
            'on'=> 1
        ]);
    }

    /**
     * Handle the UserClass "updated" event.
     *
     * @param UserClass $userClass
     * @return void
     */
    public function updated(UserClass $userClass): void
    {
        //
    }

    /**
     * Handle the UserClass "deleted" event.
     *
     * @param UserClass $userClass
     * @return void
     */
    public function deleted(UserClass $userClass): void
    {
        //
    }

    /**
     * Handle the UserClass "restored" event.
     *
     * @param UserClass $userClass
     * @return void
     */
    public function restored(UserClass $userClass): void
    {
        //
    }

    /**
     * Handle the UserClass "force deleted" event.
     *
     * @param UserClass $userClass
     * @return void
     */
    public function forceDeleted(UserClass $userClass): void
    {
        //
    }
}
