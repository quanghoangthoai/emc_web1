<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use System\Core\Controllers\AdminController;

class NotificationController extends AdminController
{
    // get list
    public function getList()
    {
        $data['page_title'] = 'Thông báo';
        $data['listNotifications'] = auth('admin')->user()->notifications()->paginate(20);
        return view('Admin::notification.list', $data);
    }

    // postBulkaction
    public function postBulkaction(Request $request)
    {
        if ($request->has('markRead')) {
            auth('admin')->user()->unreadNotifications()->update(['read_at' => now()]);
            return redirect()->route('cms.admin.list_notification')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
        }

        if ($request->has('delAll')) {
            auth('admin')->user()->notifications()->delete();
            return redirect()->route('cms.admin.list_notification')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
        }
    }

    // ajax Load
    public function ajaxLoad(Request $request)
    {
        if ($request->has('action') && $request->action == 'check_not_new') {
            auth('admin')->user()->notifications()->where('id',  $request->id)->update(['read_at' => \Carbon\Carbon::now()]);
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật trạng thái thông báo',
                'num_new_notify' => count(auth('admin')->user()->unreadNotifications->toArray())
            ]);
        } elseif ($request->has('action') && $request->action == 'mark_read_all') {
            auth('admin')->user()->unreadNotifications()->update(['read_at' => now()]);
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật trạng thái thông báo'
            ]);
        } else {
            // get num new notify
            $data['num_new_notify'] = count(auth('admin')->user()->unreadNotifications->toArray());
            $data['listNotifications'] = auth('admin')->user()->notifications->toArray();
            $html_notification = view('Admin::notification.ajax', $data)->render();

            return response()->json([
                'num_new_notify' => $data['num_new_notify'],
                'html_notification' => $html_notification
            ]);
        }
    }
}