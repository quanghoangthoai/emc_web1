<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Filterable;
    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'order',
        'category_id',
        'description',
        'content',
        'image',
        'totalhits',
        'status',
        'featured',
        'seo_title',
        'seo_image',
        'seo_keywords',
        'seo_description',
    ];

    protected $filterable = [
        'name',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function filterName($query, $value)
    {
        if ($value != '') return $query->join('service_categories', 'service_categories.id', '=', 'services.category_id')
            ->where('service_categories.name', 'LIKE', '%' . $value . '%')
            ->orWhere('services.name', 'LIKE', '%' . $value . '%')->select('services.*');
    }

    public function filterStatus($query, $value)
    {
        if ($value != -1) return $query->where('services.status', $value);
    }
}
