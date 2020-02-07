<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'order',
        'lang',
        'parent_id',
        'title',
        'slug',
        'description',
        'image',
        'featured',
        'seo_title',
        'seo_image',
        'seo_keywords',
        'seo_description',
        'status'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}