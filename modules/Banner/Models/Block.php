<?php

namespace Modules\Banner\Models;

use Eloquent;

class Block extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banner_blocks';

    /**
     * @var array
     */
    protected $fillable = [
        'lang',
        'title',
        'type',
        'form',
        'width',
        'height',
        'description',
        'status',
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class, 'block_id');
    }
}
