<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryMath
 *
 * @property int $id
 * @property string $name
 * @property int $parent_category_id
 * @property string $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryMath whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryMath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryMath whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryMath whereParentCategoryId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMath newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMath newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMath query()
 */
class CategoryMath extends Model
{

    public $timestamps = false;
    protected $table = 'categories_math';
    protected $fillable = ['name', 'parent_category_id', 'code'];
    
}
