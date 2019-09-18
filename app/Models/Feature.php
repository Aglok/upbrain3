<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public $timestamps = false;
    protected $table = 'features';
    protected $fillable = ['title', 'image', 'upgrade', 'value', 'description', 'type', 'modification'];

    public function artifacts(){
        return $this->morphedByMany(Artifact::class, 'entity', 'feature_entity');
    }
}
