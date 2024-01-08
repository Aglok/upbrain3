<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActionType
 *
 * @property int $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereName($value)
 * @mixin \Eloquent
 */
class ActionType extends Model
{
    public $timestamps = false;

    protected $table = 'action_type';
    protected $fillable = ['name'];


}
