<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ClassPerson extends Model
{
    public $timestamps = false;
    /**
     *
     * @var array
     */
    protected $touches = ['users'];

    protected $table = 'classes_person';
    protected $fillable = ['name', 'description', 'attack', 'shield', 'damage ', 'hp', 'mp', 'energy', 'critical_damage', 'critical_chance', 'image', 'sex'];

    /**
     * A user may have multiple classes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'user_class');
    }


}
