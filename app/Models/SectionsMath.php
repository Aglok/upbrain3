<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SectionsMath
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $code
 * @property-read \App\Models\CategoryMath $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsMath whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsMath whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsMath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsMath whereName($value)
 * @mixin \Eloquent
 */
class SectionsMath extends Model
{

    public $timestamps = false;

    protected $table = 'sections_math';
    protected $fillable = ['name','category_id','code'];

    public function category()
    {
        return $this->belongsTo(CategoryMath::class);
    }
}
