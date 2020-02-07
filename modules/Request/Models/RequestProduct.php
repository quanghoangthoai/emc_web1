<?php

namespace Modules\Request\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;

class RequestProduct extends Model
{
    protected $table = 'request_products';

    protected $fillable = [
        'id',
        'request_id',
        'product_id'
    ];
    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
