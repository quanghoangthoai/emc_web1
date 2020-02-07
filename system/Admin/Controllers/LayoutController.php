<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use System\Core\Controllers\AdminController;
use System\Core\Models\Layout;

class LayoutController extends AdminController
{
    public function getLayouts()
    {
        global $active_modules;
        $list_view_layout = [];
        foreach ($active_modules as $mod) {
            if (config($mod . '::layout')) {
                $arr_layout = config($mod . '::layout');
                foreach ($arr_layout as $v_layout) {
                    $db_layout = Layout::where('module', $mod)->where('view', $v_layout['view'])->first();
                    if (!$db_layout) {
                        $v_layout['module'] = $mod;
                        $db_layout = Layout::create($v_layout);
                    }

                    $list_view_layout[$mod][] = $db_layout;
                }
            }
        }
        $data['list_view_layout'] = $list_view_layout;
        return view('Admin::layouts_manager.list', $data);
    }

    public function ajaxSaveLayout(Request $request)
    {
        try {
            Layout::where('id', $request->id)->update(['layout' => $request->layout]);
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thay đổi'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'
            ]);
        }
    }
}