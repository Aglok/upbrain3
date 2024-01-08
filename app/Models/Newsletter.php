<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Newsletter
 *
 * @property int $id
 * @property int|null $type
 * @property string|null $sender_name
 * @property string $subject
 * @property string|null $body
 * @property string|null $path_files
 * @property int|null $mail_type
 * @property string|null $mail_from
 * @property int|null $emails_total
 * @property int|null $emails_sent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $dir
 * @property int|null $timeSend
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereEmailsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereEmailsTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereMailFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereMailType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter wherePathFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereTimeSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Newsletter whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter query()
 */
class Newsletter extends Model
{
    protected $table = 'newsletters';
    protected $fillable = ['id', 'type', 'sender_name', 'subject', 'body', 'path_files', 'dir', 'timeSend', 'mail_type', 'mail_from', 'emails_total', 'emails_send'];
}