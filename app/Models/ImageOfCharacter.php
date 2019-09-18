<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ImageOfCharacter
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property mixed $image
 * @property int|null $user_level
 * @property int|null $class_person_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageOfCharacter whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageOfCharacter whereClassPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageOfCharacter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageOfCharacter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageOfCharacter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImageOfCharacter whereUserLevel($value)
 * @mixin \Eloquent
 */
class ImageOfCharacter extends Model
{
    public $timestamps = false;

    protected $table = 'images_of_characters';
    protected $fillable = ['name', 'description', 'image', 'user_level', 'class_person_id', 'sex'];

    protected $casts = [
        'image' => 'image',
    ];

    /**
     * Получить всех пользователей с этим образом
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class, 'user_body')->withPivot('on');
    }
}
