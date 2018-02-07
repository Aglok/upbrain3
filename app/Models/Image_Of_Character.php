<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image_Of_Character extends Model
{
    public $timestamps = false;

    protected $table = 'images_of_characters';
    protected $fillable = ['name', 'description', 'small_image_m', 'big_image_m', 'small_image_w', 'big_image_w', 'user_level', 'class_person_id'];

    protected $casts = [
        'small_image_m' => 'image',
        'big_image_m' => 'image',
        'small_image_w' => 'image',
        'big_image_w' => 'image'
    ];
}
