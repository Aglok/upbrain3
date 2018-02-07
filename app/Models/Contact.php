<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = ['user_id', 'firstname', 'lastname', 'phone', 'address', 'email', 'friend', 'comment', 'birthday'];
}
