<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use System\Core\Controllers\AdminController;

class SettingController extends AdminController
{
    public function getSettingInfo()
    {
        return view('Admin::setting.info');
    }

    public function postSettingInfo(Request $request)
    {
        $data = $request->except(['_token']);
        foreach ($data as $config_name => $config_value) {
            cms_set_config($config_name, $config_value);
        }
        Cache::flush();
        // Log
        activity('setting')
            ->causedBy(auth('admin')->user())
            ->withProperties($data)
            ->log('Cập nhật thông tin website');
        return redirect()->route('cms.admin.setting_info')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật thông tin cấu hình']);
    }

    public function getSettingSystem()
    {
        return view('Admin::setting.system');
    }

    public function postSettingSystem(Request $request)
    {
        $data = $request->except(['_token', 'test_email']);
        foreach ($data as $config_name => $config_value) {
            cms_set_config($config_name, $config_value);
        }
        Cache::flush();
        // Log
        $data['mail_password'] = '******';
        activity('setting')
            ->causedBy(auth('admin')->user())
            ->withProperties($data)
            ->log('Cập nhật thiết lập hệ thống');
        return redirect()->route('cms.admin.setting_system')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật thông tin cấu hình']);
    }

    public function ajaxSendTestConfigMail(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_name' => 'required',
            'mail_from_address' => 'required',
            'test_email' => 'required',
        ], [
            'mail_host.required' => 'Chưa nhập máy chủ mail',
            'mail_port.required' => 'Chưa nhập cổng gửi mail',
            'mail_username.required' => 'Chưa nhập tài khoản',
            'mail_password.required' => 'Chưa nhập mật khẩu',
            'mail_from_name.required' => 'Chưa nhập đầy đủ định danh người gửi',
            'mail_from_address.required' => 'Chưa nhập đầy đủ định danh người gửi',
            'test_email.required' => 'Chưa nhập địa chỉ mail nhận tin',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        config([
            'mail.driver' => 'smtp',
            'mail.host' => $request->mail_host,
            'mail.port' => $request->mail_port,
            'mail.encryption' => $request->mail_encryption,
            'mail.username' => $request->mail_username,
            'mail.password' => $request->mail_password,
            'mail.from.address' => $request->mail_from_address,
            'mail.from.name' => $request->mail_from_name,
        ]);

        try {
            Mail::send('Admin::mail.test_config_mail', [], function ($message) use ($request) {
                $message->to($request->test_email, $request->test_email)->subject('Kiểm tra cấu hình gửi mail');
            });
            if (Mail::failures()) {
                return response()->json(['status' => false, 'message' => 'Gửi không thành công, vui lòng kiểm tra lại thông tin cấu hình.']);
            } else {
                return response()->json(['status' => true, 'message' => 'Đã gửi thư thành công, bạn có thể sử dụng thông tin này để lưu cấu hình.']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Gửi không thành công, vui lòng kiểm tra lại thông tin cấu hình.']);
        }
    }
}