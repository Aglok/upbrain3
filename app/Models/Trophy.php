<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trophy extends Model
{

    public $timestamps = false;

    protected $table = 'trophy';
    protected $fillable = ['name', 'description', 'image', 'type', 'attack', 'defense', 'magic', 'energy', 'experience', 'gold', 'rarity_id', 'weight', 'user_level'];

    public function getImageFields()
    {
        return [
            //В конце пути обязательно '/'
            'image' => ['items/trophy/', function ($directory, $originalName, $extension) {
                //выводит оригинальное название рисунка. По умолчанию название рисунков random
                return $originalName;
            }]
        ];
    }

    /**
     * @return string
     */
    public static function getlist()
    {
        return static::lists('name', 'id')->toArray();
    }
}
