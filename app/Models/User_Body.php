<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Body extends Model
{
    public $timestamps = false;
    protected $table = 'users_body';
    protected $fillable = ['image_of_character_id','user_id'];

    public function image_of_character(){
        return $this->belongsTo(Image_Of_Character::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
