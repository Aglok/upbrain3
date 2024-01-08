<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAction
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $number_current_move
 * @property string|null $actions
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction whereActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction whereNumberCurrentMove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAction whereUserId($value)
 * @mixin \Eloquent
 */
class UserAction extends Model
{
    public $timestamps = false;

    protected $table = 'user_actions';
    protected $fillable = ['user_id', 'number_current_move', 'actions'];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
