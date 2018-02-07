<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Progress extends Model
{
    protected $table = 'users_progress';
    protected $fillable = ['progress_id','user_id','progress_quality','experience','description','gift'];
    
}
