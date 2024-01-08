<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopItem
 *
 * @property int $id
 * @property int|null $artifact_id
 * @property int|null $quantity
 * @property-read \App\Models\Artifact|null $artifact
 * @method static \Illuminate\Database\Eloquent\Builder|ShopItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopItem whereArtifactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopItem whereQuantity($value)
 * @mixin \Eloquent
 */
class ShopItem extends Model
{
    public $timestamps = false;
    protected $table = 'shop_items';
    protected $fillable = ['artifact_id', 'quantity'];

    public function artifact(){
        return $this->belongsTo(\App\Models\Artifact::class)->with('subjects');
    }
}
