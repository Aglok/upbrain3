<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    public $timestamps = false;
    protected $table = 'slots';
    protected $fillable = ['name', 'description', 'type', 'visible', 'image_normal', 'image_gold', 'image_arena'];

    public function artifact(){
        return $this->belongsTo(Artifact::class);
    }
}
