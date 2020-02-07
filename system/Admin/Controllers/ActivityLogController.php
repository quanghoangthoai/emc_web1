<?php

namespace System\Admin\Controllers;

use Spatie\Activitylog\Models\Activity;
use System\Core\Controllers\AdminController;

class ActivityLogController extends AdminController
{
    public function getList()
    {
        $data['listActivity'] = Activity::orderBy('id', 'desc')->paginate(10);
        return view('Admin::activity_log.list', $data);
    }

    public function getDeleteAll()
    {
        Activity::whereNotNull('id')->delete();
        // Log
        activity('activity-log')
            ->causedBy(auth('admin')->user())
            ->log('Xóa toàn bộ nhật ký hệ thống');

        // Redirect
        return redirect()->route('cms.admin.list_activity_log')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa toàn bộ nhật ký hoạt động.']);
    }
}