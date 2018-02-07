<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Vk extends Model
{
    protected $table = 'users_vk';
    protected $fillable = ['vk_id', 'first_name', 'last_name', 'domain', 'href', 'nickname', 'gen_code'];
}
