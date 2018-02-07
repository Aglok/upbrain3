<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Artifact extends Model
{
    public $timestamps = false;

    protected $table = 'users_artifacts';
    protected $fillable = ['artifact_id', 'user_id'];

    public function artifact(){
        return $this->belongsTo(Artifact::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
