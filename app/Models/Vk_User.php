<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vk_User extends Model
{
    protected $table = 'users';
    protected $fillable = ['user_id', 'firstname', 'lastname', 'phone', 'address', 'email', 'friend', 'comment', 'birthday'];
}
