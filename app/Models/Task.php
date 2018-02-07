<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public $timestamps = false;

    protected $table = 'tasks';
    protected $fillable = ['number_task','task', 'image', 'experience', 'gold', 'grade', 'answer', 'detail', 'subject_id', 'set_of_task_id', 'original_number', 'book'];

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

    public function setOfTask()
    {
        return $this->belongsTo(\App\Models\Set_Of_Task::class);
    }

    /**
     * @param $query
     * @param $set_of_task_id
     *
     */
    public function scopeWithSetOfTask($query, $set_of_task_id)
    {
        $query->where('set_of_task_id', $set_of_task_id);
    }
}
