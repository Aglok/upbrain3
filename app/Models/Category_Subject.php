<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_Subject extends Model
{

    public $timestamps = false;
    protected $table = 'categories_subjects';
    protected $fillable = ['name', 'parent_category_id', 'code'];
    
}
