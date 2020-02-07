<?php

namespace Modules\Order\Controllers;

use Illuminate\Http\Request;
use System\Core\Controllers\AdminController as SystemAdminController;
use Modules\Request\Models\Requests;
use Modules\Product\Models\Product;
use Modules\Request\Models\RequestProduct;
use Modules\Order\Models\Order;
use Illuminate\Support\Carbon;
use Modules\Order\Models\OrderActivityLog;

class AdminController extends SystemAdminController
{
    public function getList(Request $request)
    {
        $param = $request->all();
        $filterdata = Order::filter($param);
        $data['listOrder'] = $filterdata->orderBy('id', 'desc')->paginate(5)->appends(request()->except('page'));
        if (isset($param['created_at'])) {
            $arr_time = explode(" - ", $param['created_at']);
            $param['begindate'] = $arr_time[0];
            $param['enddate'] = $arr_time[1];
        }
        $data['filterdata'] = $param;
        return view('Order::admin.list', $data);
    }

    public function getOrder($id)
    {
        $order_id = rand(1000000000, 9999999999);
        $listOrder = Order::all();
        $chek_order = false;
        if (isset($listOrder) && count($listOrder)) {
            foreach ($listOrder as $iOrder) {
                while ($iOrder['order_id'] == $order_id) {
                    $order_id = rand(1000000000, 9999999999);
                }
                if ($iOrder['request_id'] == $id) {
                    $chek_order = true;
                }
            }
        }
        if ($chek_order == false) {
            $order = Order::create([
                'order_id' => $order_id,
                'request_id' => $id,
                'created_at' => Carbon::now()
            ]);
            $new_activity_log = OrderActivityLog::create([
                'staff_id' => auth('admin')->id(),
                'action' => 'đã tạo đơn hàng',
                'created_at' => Carbon::now()
            ]);

            $new_activity_log->fill(['order_id' => $order['id']])->save();
            Requests::where('id', $id)->update(['isOrderCreated' => 1]);
        }
        $data['listActivityLog'] = OrderActivityLog::where('order_id', mod_order_get_orderid_by_request($id))->orderBy('id', 'desc')->get();
        $data['request'] = Requests::where('id', $id)->first();
        $requestProduct = [];
        if ($data['request']->requestProduct) {
            $requestProduct = RequestProduct::Where('request_id', $id)->pluck('product_id')->toArray();
            $listProduct =  Product::whereIn('id', $requestProduct)->get();
        }
        $data['listProduct'] = $listProduct;
        return view('Order::admin.order', $data);
    }

    public function getCancelOrder($id)
    {
        Order::where('id', $id)->update(['status' => 4, 'cancel_at' => Carbon::now(), 'staff_id' => auth('admin')->id()]);
        $data = Order::where('id', $id)->first();
        OrderActivityLog::insert([
            'order_id' => $id,
            'staff_id' => auth('admin')->id(),
            'action' => 'đã hủy đơn hàng',
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('mod_order.admin.order', $data->request_id)->with('flash_data', ['type' => 'success', 'message' => 'Hủy thành công']);
    }

    public function getProcessOrder($id)
    {
        Order::where('id', $id)->update(['status' => 2, 'process_at' => Carbon::now(), 'staff_id' => auth('admin')->id()]);
        $data = Order::where('id', $id)->first();
        OrderActivityLog::insert([
            'order_id' => $id,
            'staff_id' => auth('admin')->id(),
            'action' => 'đang xử lý đơn hàng',
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('mod_order.admin.order', $data->request_id)->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật trạng thái']);
    }

    public function getFinishOrder($id)
    {
        Order::where('id', $id)->update(['status' => 3, 'finish_at' => Carbon::now(), 'staff_id' => auth('admin')->id()]);
        $data = Order::where('id', $id)->first();
        OrderActivityLog::insert([
            'order_id' => $id,
            'staff_id' => auth('admin')->id(),
            'action' => 'hoàn thành đơn hàng',
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('mod_order.admin.order', $data->request_id)->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật trạng thái']);
    }

    public function getOpenOrder($id)
    {
        Order::where('id', $id)->update(['status' => 2, 'process_at' => Carbon::now(), 'staff_id' => auth('admin')->id()]);
        $data = Order::where('id', $id)->first();
        OrderActivityLog::insert([
            'order_id' => $id,
            'staff_id' => auth('admin')->id(),
            'action' => 'mở lại đơn hàng',
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('mod_order.admin.order', $data->request_id)->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật trạng thái']);
    }
    public function index()
    {

        $chart_options = [
            'chart_title' => 'Lượt xem',
            'report_type' => 'group_by_string',
            'model' => 'Modules\Order\Models\Order',
            'group_by_field' => 'request_id',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'totalhits',
            'chart_type' => 'line',
        ];

        $chart1 = new LaravelChart($chart_options);
        return view('Order::widgets.revenue', compact('chart1'));
    }
}
