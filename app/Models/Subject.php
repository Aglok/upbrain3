<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $alias
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereName($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = ['name','alias'];
}
