<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Mission extends Model
{
    protected $table = 'users_missions';
    protected $fillable = ['user_id','mission_id', 'created_at', 'updated_at'];

    public function mission(){
        return $this->belongsTo(Mission::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
