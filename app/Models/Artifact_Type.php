<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artifact_Type extends Model
{
    public $timestamps = false;

    protected $table = 'artifacts_type';
    protected $fillable = ['name', 'description', 'dir'];
    
}
