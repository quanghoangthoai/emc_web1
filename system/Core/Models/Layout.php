<?php

namespace System\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'layouts';

    /**
     * @var array
     */
    protected $fillable = [
        'module',
        'view',
        'layout',
        'title',
        'description'
    ];
}