<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = [
        'lang',
        'category_id',
        'title',
        'slug',
        'image',
        'description',
        'content',
        'source',
        'attachments',
        'tags',
        'author',
        'featured',
        'created_by',
        'public_at',
        'totalhits',
        'seo_title',
        'seo_image',
        'seo_keywords',
        'seo_description',
        'status'
    ];

    public $dates = ['created_at', 'updated_at', 'public_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}