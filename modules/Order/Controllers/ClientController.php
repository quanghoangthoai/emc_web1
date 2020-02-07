<?php

namespace Modules\Order\Controllers;

use System\Core\Controllers\WebController;
use Modules\Order\Models\Order;
use Modules\Request\Models\Requests;

class ClientController extends WebController
{
    public function getOrders()
    {
        $client_id = auth('web')->id();
        $arr_request_id = [];
        $listRequest = Requests::where('client_id', $client_id)->get();
        foreach ($listRequest as $iReq) {
            $arr_request_id[] = $iReq['id'];
        }
        $listOrder = Order::whereIn('request_id', $arr_request_id)->orderBy('id', 'desc')->get();
        $data['listRequest'] = $listRequest;
        $data['listOrder'] = $listOrder;
        return view('Order::web.order', $data);
    }

    public function getDetailOrder($order_id)
    {
        $client_id = auth('web')->id();
        $data['order'] = Order::where('order_id', $order_id)->first();
        $data['request'] = Requests::where('id', $data['order']['request_id'])->first();
        if ($data['request']['client_id'] == $client_id) {
            return view('Order::web.detail_order', $data);
        }
        return redirect()->route('client.orders');
    }
}
