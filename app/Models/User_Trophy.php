<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Trophy extends Model
{
    public $timestamps = false;

    protected $table = 'users_trophy';
    protected $fillable = ['trophy_id', 'user_id'];
}
