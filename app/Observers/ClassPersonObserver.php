<?php

namespace App\Observers;

use App\Models\ClassPerson;

class ClassPersonObserver
{
    /**
     * Handle the class person "created" event.
     *
     * @param  \App\Models\ClassPerson  $classPerson
     * @return void
     */
    public function created(ClassPerson $classPerson)
    {

    }

    //Выбор директории взависимости от пола образа
    public function creating(ClassPerson $classPerson)
    {
        $classPerson->image = 'images/items/classes/'.(($classPerson->sex == 'M') ? 'man': 'woman');
    }

    /**
     * Handle the class person "updated" event.
     *
     * @param  \App\Models\ClassPerson  $classPerson
     * @return void
     */
    public function updated(ClassPerson $classPerson)
    {
        //
    }

    /**
     * Handle the class person "deleted" event.
     *
     * @param  \App\Models\ClassPerson  $classPerson
     * @return void
     */
    public function deleted(ClassPerson $classPerson)
    {
        //
    }

    /**
     * Handle the class person "restored" event.
     *
     * @param  \App\Models\ClassPerson  $classPerson
     * @return void
     */
    public function restored(ClassPerson $classPerson)
    {
        //
    }

    /**
     * Handle the class person "force deleted" event.
     *
     * @param  \App\Models\ClassPerson  $classPerson
     * @return void
     */
    public function forceDeleted(ClassPerson $classPerson)
    {
        //
    }
}
