<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set_Of_Task extends Model
{

    protected $table = 'set_of_tasks';
    protected $fillable = ['id','name','alias','image','type','description','created_at','updated_at'];

    public function set_of_task_type(){
        return $this->belongsTo(\App\Models\Set_Of_Task_Type::class, 'type');
    }

    public function tasks(){
        return $this->hasMany(\App\Models\Task::class, 'set_of_task_id');
    }
}
