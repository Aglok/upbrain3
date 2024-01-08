<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserNewsletter
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $newsletter_id
 * @property int|null $is_sent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNewsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNewsletter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNewsletter whereIsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNewsletter whereNewsletterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNewsletter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNewsletter whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|UserNewsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNewsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNewsletter query()
 */
class UserNewsletter extends Model
{
    protected $table = 'user_newsletter';
    protected $fillable = ['user_id', 'newsletter_id', 'is_sent'];
}
