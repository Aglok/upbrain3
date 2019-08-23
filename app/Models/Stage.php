<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stage
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stage extends Model
{
    protected $table = 'stages';
    protected $fillable = ['name','alias','description'];

}
