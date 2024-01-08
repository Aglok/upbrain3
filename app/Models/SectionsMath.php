<?php namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SectionsMath
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $code
 * @property-read CategoryMath $category
 * @method static Builder|\App\Models\SectionsMath whereCategoryId($value)
 * @method static Builder|\App\Models\SectionsMath whereCode($value)
 * @method static Builder|\App\Models\SectionsMath whereId($value)
 * @method static Builder|\App\Models\SectionsMath whereName($value)
 * @mixin \Eloquent
 * @method static Builder|SectionsMath newModelQuery()
 * @method static Builder|SectionsMath newQuery()
 * @method static Builder|SectionsMath query()
 */
class SectionsMath extends Model
{

    public $timestamps = false;

    protected $table = 'sections_math';
    protected $fillable = ['name','category_id','code'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryMath::class);
    }
}
