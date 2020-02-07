<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'lang',
        'category_id',
        'name',
        'image',
        'description',
        'content',
        'price',
        'unit_type',
        'enable_sale',
        'sale_price',
        'sale_begintime',
        'sale_endtime',
        'featured',
        'display_price',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}