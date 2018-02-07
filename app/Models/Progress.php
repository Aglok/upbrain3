<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    
    protected $table = 'progress';
    protected $fillable = ['id','name','type', 'rank' , 'quality', 'description','image','created_at','updated_at'];
    
}
