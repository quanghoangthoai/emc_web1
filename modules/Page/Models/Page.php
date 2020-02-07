<?php

namespace Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'status',
        'order',
        'seo_title',
        'seo_image',
        'seo_keywords',
        'seo_description',
    ];
}