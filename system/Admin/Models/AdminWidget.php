<?php

namespace System\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminWidget extends Model
{
    protected $table = 'admin_widgets';

    protected $fillable = [
        'module',
        'name',
        'title',
        'group',
        'status',
        'order',
        'config',
    ];
}