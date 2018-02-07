<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter_User extends Model
{
    protected $table = 'newsletters_users';
    protected $fillable = ['user_id', 'newsletter_id', 'is_sent'];
}
