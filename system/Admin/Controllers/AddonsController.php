<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use System\Core\Controllers\AdminController;

class AddonsController extends AdminController
{
    public function getAddons()
    {
        return view('Admin::addons.config');
    }

    public function postAddons(Request $request)
    {
        $data = $request->except(['_token']);
        if (!$request->has('enable_login_facebook')) $data['enable_login_facebook'] = 0;
        if (!$request->has('enable_login_google')) $data['enable_login_google'] = 0;
        if (!$request->has('enable_vnpay')) $data['enable_vnpay'] = 0;
        foreach ($data as $config_name => $config_value) {
            cms_set_config($config_name, $config_value);
        }
        Cache::flush();
        // Log
        activity('addons')
            ->causedBy(auth('admin')->user())
            ->withProperties($data)
            ->log('Cập nhật thông tin cấu hình addons');
        return redirect()->route('cms.admin.addons')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật thông tin cấu hình']);
    }
}