<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_Subject_Physics extends Model
{

    public $timestamps = false;
    protected $table = 'categories_subjects_physics';
    protected $fillable = ['name', 'parent_category_id', 'code'];
    
}
