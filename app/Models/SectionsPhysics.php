<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SectionsPhysics
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string|null $code
 * @property-read \App\Models\CategoryPhysics $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsPhysics whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsPhysics whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsPhysics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SectionsPhysics whereName($value)
 * @mixin \Eloquent
 */
class SectionsPhysics extends Model
{

    public $timestamps = false;

    protected $table = 'sections_physics';
    protected $fillable = ['name', 'category_id', 'code'];

    public function category()
    {
        return $this->belongsTo(CategoryPhysics::class);
    }
}
