<?php

namespace Modules\Banner\Models;

use Eloquent;

class Banner extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banners';

    /**
     * @var array
     */
    protected $fillable = [
        'block_id',
        'title',
        'file_src',
        'file_alt',
        'link',
        'target',
        'begin_time',
        'expired_time',
        'description',
        'clicks',
        'order',
        'status',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
}
