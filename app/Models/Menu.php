<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'menus';
    protected $fillable = ['title', 'path', 'parent_id'];

}
