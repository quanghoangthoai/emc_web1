<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'service_categories';

    protected $fillable = [
        'parent_id',
        'order',
        'name',
        'slug',
        'image',
        'status',
        'description',
        'seo_title',
        'seo_image',
        'seo_keywords',
        'seo_description',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}