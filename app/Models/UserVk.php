<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserVk
 *
 * @property int $id
 * @property int|null $vk_id
 * @property string $first_name
 * @property string $last_name
 * @property string $domain
 * @property string $href
 * @property string|null $nickname
 * @property int|null $gen_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereGenCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserVk whereVkId($value)
 * @mixin \Eloquent
 */
class UserVk extends Model
{
    protected $table = 'users_vk';
    protected $fillable = ['vk_id', 'first_name', 'last_name', 'domain', 'href', 'nickname', 'gen_code'];
}
