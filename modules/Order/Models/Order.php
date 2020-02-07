<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Filterable;
use Illuminate\Support\Carbon;
use Modules\Request\Models\Requests;

class Order extends Model
{
    use Filterable;
    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'request_id',
        'staff_id',
        'status',
        'finish_at',
        'process_at',
        'cancel_at',
        'created_at'
    ];
    protected $filterable = [
        'order_id',
        'status',
        'created_at'
    ];
    public function request()
    {
        return $this->belongsTo(Requests::class, 'request_id');
    }

    public function orderactivitylog()
    {
        return $this->hasMany(OrderActivityLog::class, 'order_id');
    }

    public function filterOrderId($query, $value)
    {
        if ($value != '') return $query->join('users', 'users.id', '=', 'orders.staff_id')
            ->join('requests', 'requests.id', '=', 'orders.request_id')
            ->join('request_products', 'request_products.request_id', '=', 'requests.id')
            ->join('products', 'products.id', '=', 'request_products.product_id')
            ->where('orders.order_id', 'LIKE', '%' . $value . '%')
            ->orWhere('users.display_name', 'LIKE', '%' . $value . '%')
            ->orWhere('requests.client_name', 'LIKE', '%' . $value . '%')
            ->orWhere('requests.client_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('requests.client_email', 'LIKE', '%' . $value . '%')
            ->orWhere('products.name', 'LIKE', '%' . $value . '%')->select('orders.*');
    }

    public function filterStatus($query, $value)
    {
        if ($value != -1) return $query->where('orders.status', $value);
    }

    public function filterCreatedAt($query, $value)
    {
        if ($value) {
            $value = urldecode($value);
            $arr_time = explode(" - ", $value);
            $begintime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[0] . ' 00:00')->format('Y-m-d H:i:s');
            $endtime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[1] . '23:59')->format('Y-m-d H:i:s');
            return $query->where('orders.created_at', '>=', $begintime)->where('orders.created_at', '<=', $endtime);
        }
    }
}
