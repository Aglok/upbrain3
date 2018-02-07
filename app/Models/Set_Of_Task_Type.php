<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set_Of_Task_Type extends Model
{
    public $timestamps = false;
    protected $table = 'set_of_tasks_type';
    protected $fillable = ['name','description'];
    
}