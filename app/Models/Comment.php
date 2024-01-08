<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $text
 * @property int|null $parent_id
 * @property int|null $post_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 */
class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['name', 'email', 'text' ,'parent_id', 'post_id'];

}
