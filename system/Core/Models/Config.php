<?php

namespace System\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'configs';

    /**
     * @var array
     */
    protected $fillable = [
        'lang',
        'module',
        'name',
        'value',
    ];

    public $timestamps = false;
}