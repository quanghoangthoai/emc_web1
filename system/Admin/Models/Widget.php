<?php

namespace System\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'widgets';

    /**
     * @var array
     */
    protected $fillable = [
        'module',
        'name',
        'title',
        'group',
        'status',
        'order',
        'config'
    ];
}