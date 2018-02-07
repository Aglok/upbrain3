<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    public $timestamps = false;
    protected $table = 'rarity';
    protected $fillable = ['name', 'description', 'type'];
}
