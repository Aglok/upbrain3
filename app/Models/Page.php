<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property int|null $no_blocks
 * @property int|null $no_blocks_title
 * @property string|null $type
 * @property string|null $class_image_header
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $link
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int $order
 * @property string $title
 * @property string|null $title_4U
 * @property string|null $style
 * @property string|null $style_title
 * @property string|null $style_title_4U
 * @property string $text
 * @property string|null $subject_title
 * @property string|null $subject_image
 * @property string|null $subject_text
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $menus
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereClassImageHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereNoBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereNoBlocksTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereStyleTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereStyleTitle4U($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereSubjectImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereSubjectText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereSubjectTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTitle4U($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = [
        'no_blocks',
        'no_blocks_title',
        'type',
        'class_image_header',
        'keywords',
        'description',
        'link',
        'title',
        'title_4U',
        'style',
        'style_title',
        'style_title_4U',
        'text',
        'parent_id',
        'order',
        'subject',
        'subject_title',
        'subject_image',
        'subject_text'
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

}
