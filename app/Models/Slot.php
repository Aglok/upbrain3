<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slot
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $type
 * @property int|null $visible
 * @property string|null $image_normal
 * @property string|null $image_gold
 * @property string|null $image_arena
 * @property-read \App\Models\Artifact $artifact
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereImageArena($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereImageGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereImageNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereVisible($value)
 * @mixin \Eloquent
 */
class Slot extends Model
{
    public $timestamps = false;
    protected $table = 'slots';
    protected $fillable = ['name', 'description', 'type', 'visible', 'image_normal', 'image_gold', 'image_arena'];

    public function artifact(){
        return $this->belongsTo(Artifact::class);
    }
}
