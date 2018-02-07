<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trophy_Type extends Model
{
    public $timestamps = false;

    protected $table = 'trophy_type';
    protected $fillable = ['name', 'description'];

    public static function getList()
    {

        return static::lists('name', 'id')->toArray();
    }
}
