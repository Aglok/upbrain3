<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClassType
 *
 * @property int $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereName($value)
 * @mixin \Eloquent
 * @property int|null $parent
 * @property int|null $level
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassType whereParent($value)
 */
class ClassType extends Model
{
    public $timestamps = false;

    protected $table = 'classes_type';
    protected $fillable = ['name'];
}
