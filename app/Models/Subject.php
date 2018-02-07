<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    public $timestamps = false;

    protected $table = 'subjects';
    protected $fillable = ['name','category_id','code'];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category_Subject::class);
    }
}
