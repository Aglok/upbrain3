<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';
    protected $fillable = ['id', 'type', 'sender_name', 'subject', 'body', 'path_files', 'dir', 'timeSend', 'mail_type', 'mail_from', 'emails_total', 'emails_send'];
}