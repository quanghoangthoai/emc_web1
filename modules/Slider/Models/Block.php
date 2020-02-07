<?php

namespace Modules\Slider\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'slider_blocks';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function slides()
    {
        return $this->hasMany(Slide::class, 'block_id');
    }
}