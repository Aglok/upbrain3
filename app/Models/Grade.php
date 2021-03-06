<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Grade
 *
 * @mixin \Eloquent
 */
class Grade extends Model
{
    protected $table = 'grade';
    protected $fillable = ['subject_id', 'user_id', 'grade_char', 'sum_tasks', 'full', 'time', 'number_lesson', 'sum_exp', 'sum_gold', 'created_at', 'updated_at'];
}
