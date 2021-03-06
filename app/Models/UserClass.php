<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserClass
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $class_person_id
 * @property-read \App\Models\ClassPerson|null $class_person
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserClass whereClassPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserClass whereUserId($value)
 * @mixin \Eloquent
 */
class UserClass extends Model
{
    public $timestamps = false;
    
    protected $table = 'user_class';
    protected $fillable = ['user_id', 'class_person_id'];

    public function class_person(){
        return $this->belongsTo(ClassPerson::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
