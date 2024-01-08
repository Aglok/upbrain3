<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserBody
 *
 * @property int $id
 * @property int|null $image_of_character_id
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\ImageOfCharacter|null $image_of_character
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBody whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBody whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBody whereImageOfCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBody whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBody whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $on
 * @method static \Illuminate\Database\Eloquent\Builder|UserBody newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBody newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBody query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBody whereOn($value)
 */
class UserBody extends Model
{
    public $timestamps = false;
    protected $table = 'user_body';
    protected $fillable = ['image_of_character_id','user_id', 'active'];

    public function image_of_character(){
        return $this->belongsTo(ImageOfCharacter::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
