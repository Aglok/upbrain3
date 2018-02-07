<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_Physics extends Model
{

    public $timestamps = false;

    protected $table = 'tasks_physics';
    protected $fillable = ['number_task', 'task', 'image_a' , 'image_b' ,'experience', 'gold', 'grade', 'answer', 'detail', 'subject_id', 'set_of_task_id', 'original_number', 'book'];

    public function subject()
    {
        //Вставляем скрипт mathjax для преобразования формул
//        AssetManager::addStyle('../css/aglok/tasks.css');
//        AssetManager::addScript('../js/aglok/mathjax/MathJax.js?config=default');
//        AssetManager::addScript('//cdn.mathjax.org/mathjax/latest/MathJax.js?config=default');
//        AssetManager::addScript('../js/aglok/tasks.js');

        return $this->belongsTo(\App\Models\Subject_Physics::class);
    }
}
