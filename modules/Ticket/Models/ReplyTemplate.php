<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyTemplate extends Model
{
    protected $table = 'ticket_reply_templates';

    protected $fillable = [
        'order',
        'name',
        'content'
    ];
}
