<?php

use Modules\Request\Models\Requests;
use Modules\Product\Models\Product;
use Modules\Request\Models\RequestProduct;
use Modules\Order\Models\Order;

if (!function_exists('mod_order_get_html_status')) {
    function mod_order_get_html_status($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success">Mới</span>';
        } elseif ($status == 2) {
            return '<span class="badge badge-primary">Đang xử lý</span>';
        } elseif ($status == 3) {
            return '<span class="badge badge-warning">Hoàn thành</span>';
        } elseif ($status == 4) {
            return '<span class="badge badge-danger">Hủy bỏ</span>';
        }
        return '';
    }
}

if (!function_exists('mod_order_get_html_status_web')) {
    function mod_order_get_html_status_web($status)
    {
        if ($status == 1) {
            return '<span class="text-success">Mới</span>';
        } elseif ($status == 2) {
            return '<span class="text-primary">Đang xử lý</span>';
        } elseif ($status == 3) {
            return '<span class="text-warning">Hoàn thành</span>';
        } elseif ($status == 4) {
            return '<span class="text-danger">Tạm hủy</span>';
        }
        return '';
    }
}

if (!function_exists('mod_order_get_staus_by_request')) {
    function mod_order_get_staus_by_request($id)
    {
        $data = Order::where('request_id', $id)->first();
        if (isset($data)) {
            return $data->status;
        }
        return '';
    }
}

if (!function_exists('mod_order_get_orderid_by_request')) {
    function mod_order_get_orderid_by_request($id)
    {
        $data = Order::where('request_id', $id)->first();
        if (isset($data)) {
            return $data->id;
        }
        return '';
    }
}

if (!function_exists('mod_order_get_time')) {
    function mod_order_get_time($status)
    {
        if ($status == 1) {
            return 'created_at';
        } elseif ($status == 2) {
            return 'process_at';
        } elseif ($status == 3) {
            return 'finish_at';
        } elseif ($status == 4) {
            return 'cancel_at';
        }
        return '';
    }
}

if (!function_exists('mod_order_get_info_customer')) {
    function mod_order_get_info_customer($request_id)
    {
        $data = [];
        $info = Requests::where('id', $request_id)->first();
        if (isset($info)) {
            $data[] = 'Họ tên: ' . '<strong>' . $info['client_name'] . '</strong>';
            $data[] = 'Số điện thoại: ' . '<strong>' . $info['client_phone'] . '</strong>';
            $data[] = 'Email: ' . '<strong>' . $info['client_email'] . '</strong>';
        }
        return $data;
    }
}


if (!function_exists('mod_order_get_name_product')) {
    function mod_order_get_name_product($request_id)
    {
        $requestProduct = [];
        $requestProduct = RequestProduct::Where('request_id', $request_id)->pluck('product_id')->toArray();
        $listProduct =  Product::whereIn('id', $requestProduct)->get();
        return $listProduct;
    }
}


if (!function_exists('mod_order_list_status')) {
    function mod_order_list_status()
    {
        $data = [
            '1' => 'Mới',
            '2' => 'Đang xử lý',
            '3' => 'Hoàn thành',
            '4' => 'Hủy bỏ'
        ];
        return $data;
    }
}
