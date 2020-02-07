<?php

namespace System\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'icon',
        'description',
        'version',
        'order',
        'status'
    ];
}