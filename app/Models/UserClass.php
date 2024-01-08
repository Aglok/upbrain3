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
 * @method static \Illuminate\Database\Eloquent\Builder|UserClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserClass query()
 * @property int|null $active
 * @method static \Illuminate\Database\Eloquent\Builder|UserClass whereActive($value)
 */
class UserClass extends Model
{
    public $timestamps = false;
    
    protected $table = 'user_class';
    protected $fillable = ['user_id', 'class_person_id', 'on'];

    public function class_person(){
        return $this->belongsTo(ClassPerson::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
