<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    protected $table = 'user_properties';
    protected $fillable = ['user_id', 'attack', 'shield', 'damage', 'hp', 'mp', 'energy', 'critical_damage', 'critical_chance'];
}
