<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;

class OrderActivityLog extends Model
{
    protected $table = 'orders_activity_log';

    protected $fillable = [
        'order_id',
        'staff_id',
        'action'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
