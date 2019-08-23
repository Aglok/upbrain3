<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $path
 * @property int|null $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereTitle($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'menus';
    protected $fillable = ['title', 'path', 'parent_id'];

}
