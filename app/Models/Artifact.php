<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artifact extends Model
{

    public $timestamps = false;

    protected $table = 'artifacts';
    protected $fillable = ['name', 'description', 'image', 'artifact_type_id', 'attack', 'damage_min', 'damage_max', 'defense', 'magic', 'energy', 'increase_experience', 'increase_gold', 'rarity_id', 'weight', 'user_level', 'price', 'class_person_id'];
    
}
