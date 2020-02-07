<?php

namespace System\Admin\Controllers;

use System\Core\Controllers\AdminController;

class PermissionController extends AdminController
{
    public function getList()
    {
        return view('Admin::permission.list');
    }

    public function ajaxSyncPermissions()
    {
        try {
            sync_all_permissions();
            return response()->json([
                'status' => true,
                'msg' => 'Đã đồng bộ tất cả quyền hạn',
                'html' => view('Admin::permission.sync')->render()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'msg' => 'Đã xảy ra lỗi. Thử lại hoặc liên hệ với kỹ thuật viên.'
            ]);
        }
    }
}