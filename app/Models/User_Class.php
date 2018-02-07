<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Class extends Model
{
    public $timestamps = false;
    
    protected $table = 'users_class';
    protected $fillable = ['user_id', 'class_person_id'];

    public function class_person(){
        return $this->belongsTo(Class_Person::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
