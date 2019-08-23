<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SetOfTaskType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $code_subject
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskType whereCodeSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SetOfTaskType whereName($value)
 * @mixin \Eloquent
 */
class SetOfTaskType extends Model
{
    public $timestamps = false;
    protected $table = 'set_of_tasks_type';
    protected $fillable = ['name','description'];
    
}