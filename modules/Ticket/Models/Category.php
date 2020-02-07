<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ticket_categories';

    protected $fillable = [
        'order',
        'name',
        'status'
    ];

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }
}
