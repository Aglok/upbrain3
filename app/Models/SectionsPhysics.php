<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SectionsPhysics
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string|null $code
 * @property-read CategoryPhysics $category
 * @method static Builder|SectionsPhysics whereCategoryId($value)
 * @method static Builder|SectionsPhysics whereCode($value)
 * @method static Builder|SectionsPhysics whereId($value)
 * @method static Builder|SectionsPhysics whereName($value)
 * @mixin \Eloquent
 * @method static Builder|SectionsPhysics newModelQuery()
 * @method static Builder|SectionsPhysics newQuery()
 * @method static Builder|SectionsPhysics query()
 */
class SectionsPhysics extends Model
{

    public $timestamps = false;

    protected $table = 'sections_physics';
    protected $fillable = ['name', 'category_id', 'code'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryPhysics::class);
    }
}
