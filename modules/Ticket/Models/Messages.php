<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'ticket_messages';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'content',
        'attachments',
        'reply_at'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
