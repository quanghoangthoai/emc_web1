<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;
use Modules\User\Models\User;
use Modules\Ticket\Models\Filterable;
use Illuminate\Support\Carbon;
use Modules\User\Models\Userinfo;


class Ticket extends Model
{
    use Filterable;
    protected $table = 'tickets';

    protected $fillable = [
        'order',
        'title',
        'customer_id',
        'staff_id',
        'product_id',
        'category_id',
        'category_description',
        'status',
        'created_at'
    ];

    protected $filterable = [
        'title',
        'status',
        'created_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function messages()
    {
        return $this->hasMany(Messages::class, 'ticket_id');
    }

    public function custom()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function filterTitle($query, $value)
    {
        if ($value != '') return $query->join('users', 'users.id', '=', 'tickets.customer_id')
            ->join('products', 'products.id', '=', 'tickets.product_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->where('tickets.title', 'LIKE', '%' . $value . '%')
            ->orWhere('users.display_name', 'LIKE', '%' . $value . '%')
            ->orWhere('products.name', 'LIKE', '%' . $value . '%')
            ->orWhere('product_categories.name', 'LIKE', '%' . $value . '%')->select('tickets.*');
    }

    public function filterStatus($query, $value)
    {
        if ($value != -1) return $query->where('tickets.status', $value);
    }

    public function filterCreatedAt($query, $value)
    {
        if ($value) {
            $value = urldecode($value);
            $arr_time = explode(" - ", $value);
            $begintime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[0] . ' 00:00')->format('Y-m-d H:i:s');
            $endtime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[1] . '23:59')->format('Y-m-d H:i:s');
            return $query->where('tickets.created_at', '>=', $begintime)->where('tickets.created_at', '<=', $endtime);
        }
    }
}
