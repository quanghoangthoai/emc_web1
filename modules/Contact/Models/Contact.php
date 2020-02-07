<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'service',
        'title',
        'sender_name',
        'sender_phone',
        'sender_email',
        'sender_address',
        'sender_ip',
        'sender_content',
        'reply_by',
        'reply_at',
        'reply_content',
        'reply_attachments',
        'status',
    ];
}
