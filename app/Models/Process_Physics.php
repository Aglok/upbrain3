<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process_Physics extends Model
{
    protected $table = 'processes_physics';
    protected $fillable = ['user_id', 'number_task', 'stage_id', 'experience', 'gold', 'rating', 'comment', 'number_lesson'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
