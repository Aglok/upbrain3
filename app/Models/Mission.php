<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';
    protected $fillable = ['name', 'description', 'list_tasks_id', 'list_artifacts_id', 'condition', 'user_level', 'set_of_tasks_id'];
}
