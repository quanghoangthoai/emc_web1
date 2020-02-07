<?php

namespace Modules\Slider\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slider_slides';

    protected $fillable = [
        'title',
        'link',
        'image',
        'description',
        'status',
        'block_id',
        'order',
        'button_text'
    ];

    public function block()
    {
        return $this->hasMany(Slide::class, 'block_id');
    }
}