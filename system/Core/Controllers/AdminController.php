<?php

namespace System\Core\Controllers;

class AdminController extends BaseController
{
    function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if (auth('admin')->check()) {
                if (auth('admin')->user()->status == 0) {
                    auth('admin')->logout();
                    session()->flush();
                    return redirect()->route('mod_user.admin.login')->with('flash_data', ['type' => 'error', 'message' => 'Tài khoản của bạn đã bị khóa.']);
                } else {
                    if (!check_permission('dashboard')) {
                        auth('admin')->logout();
                        session()->flush();
                        return redirect()->route('mod_user.admin.login')->with('flash_data', ['type' => 'error', 'message' => 'Tài khoản không hợp lệ hoặc không có quyền truy cập.']);
                    }
                }
            }
            return $next($request);
        });
    }
}