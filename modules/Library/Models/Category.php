<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'library_categories';

    protected $fillable = [
        'id',
        'name',
        'order',
        'slug',
        'format_type',
        'parent_id',
        'image',
        'description',
        'status'
    ];
    public function document()
    {
        return $this->hasMany(Document::class, 'category_id');
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
