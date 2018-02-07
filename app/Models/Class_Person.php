<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Class_Person extends Model
{
    public $timestamps = false;

    protected $table = 'classes_person';
    protected $fillable = ['name', 'description', 'attack', 'defense', 'magic', 'energy', 'health_point', 'increase_experience', 'increase_gold', 'skill_1_id', 'skill_2_id', 'skill_3_id', 'icon_man', 'icon_woman'];
    
}
