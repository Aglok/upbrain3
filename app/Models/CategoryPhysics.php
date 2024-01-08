<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryPhysics
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_category_id
 * @property string|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPhysics whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPhysics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPhysics whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPhysics whereParentCategoryId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryPhysics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryPhysics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryPhysics query()
 */
class CategoryPhysics extends Model
{

    public $timestamps = false;
    protected $table = 'categories_physics';
    protected $fillable = ['name', 'parent_category_id', 'code'];
    
}
