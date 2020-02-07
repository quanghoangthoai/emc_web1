<?php

namespace Modules\Request\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Order\Models\Order;

class Requests extends Model
{
    use Filterable;
    protected $table = 'requests';

    protected $fillable = [
        'id',
        'staff_id',
        'client_id',
        'client_name',
        'client_phone',
        'client_email',
        'total',
        'payment',
        'payment_method',
        'note',
        'status',
        'order',
        'vat_percent',
        'sale_percent',
        'isOrderCreated',
        'confirm_image',
        'created_at'
    ];
    public function order()
    {
        return $this->hasOne(Order::class, 'request_id');
    }
    public function requestProduct()
    {
        return $this->hasMany(RequestProduct::class, 'request_id');
    }

    protected $filterable = [
        'client_name',
        'status',
        'created_at',
    ];

    public function filterClientName($query, $value)
    {
        if (!empty($value)) return $query->where('client_name', 'LIKE', '%' . $value . '%');
    }

    public function filterStatus($query, $value)
    {
        if ($value != -1) return $query->where('status', $value);
    }

    public function filterCreatedAt($query, $value)
    {
        if ($value) {
            $value = urldecode($value);
            $arr_time = explode(" - ", $value);
            $begintime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[0] . ' 00:00')->format('Y-m-d H:i:s');
            $endtime = Carbon::createFromFormat('d/m/Y H:i', $arr_time[1] . '23:59')->format('Y-m-d H:i:s');
            return $query->where('created_at', '>=', $begintime)->where('created_at', '<=', $endtime);
        }
    }
}
