<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Action
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $action_type_id
 * @property-read \App\Models\ActionType|null $action_type
 * @method static \Illuminate\Database\Eloquent\Builder|Action newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Action query()
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereActionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Action whereName($value)
 * @mixin \Eloquent
 */
class Action extends Model
{
    public $timestamps = false;

    protected $table = 'actions';
    protected $fillable = ['name', 'action_type_id'];

    /**
     * Получить тип дейсвия
     */
    public function action_type(){
        return $this->belongsTo(ActionType::class);
    }
}
