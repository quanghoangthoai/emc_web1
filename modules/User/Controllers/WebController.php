<?php

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use System\Core\Controllers\WebController as SystemWebController;

class WebController extends SystemWebController
{
    public function getLogin(Request $request)
    {
        if (auth('web')->check()) {
            $redirect_to = !empty($request->input('redirect_to')) ? base64_decode($request->redirect_to) : route('client.index');
            return redirect()->to($redirect_to);
        }
        return view('User::web.login');
    }

    public function postLogin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Chưa nhập email',
            'password.required' => 'Chưa nhập mật khẩu'
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        $is_remember = $request->has('is_remember') ? true : false;

        if (auth('web')->attempt(['email' => $request->email, 'password' => $request->password], $is_remember)) {
            if (auth('web')->user()->status == 0) {
                auth('web')->logout();
                session()->flush();
                return response()->json(['status' => false, 'message' => 'Tài khoản của bạn đang bị khóa']);
            } else {
                $redirect_to = ($request->has('redirect_to') && !empty($request->redirect_to)) ? base64_decode($request->redirect_to) : route('client.index');
                return response()->json(['status' => true, 'message' => 'Đăng nhập thành công', 'redirect_to' => $redirect_to]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Thông tin đăng nhập không chính xác']);
        }
    }

    public function getLogout()
    {
        if (auth('web')->check()) {
            auth('web')->logout();
            session()->flush();
        }
        return redirect()->back();
    }
}