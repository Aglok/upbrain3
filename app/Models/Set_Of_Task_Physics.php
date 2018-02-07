<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set_Of_Task_Physics extends Model
{
    protected $table = 'set_of_tasks_physics';
    protected $fillable = ['name', 'alias', 'image', 'type', 'description', 'created_at', 'updated_at'];

    public function set_of_task_type(){
        return $this->belongsTo(\App\Models\Set_Of_Task_Type::class, 'type');
    }
}
