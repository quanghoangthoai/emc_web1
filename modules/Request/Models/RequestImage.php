<?php

namespace Modules\Request\Models;

use Illuminate\Database\Eloquent\Model;


class RequestImage extends Model
{
    protected $table = 'request_images';

    protected $fillable = [
        'id',
        'request_id',
        'path'
    ];
    public function request()
    {
        return $this->belongsTo(Requests::class, 'request_id');
    }
}
