<?php

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use Modules\User\Models\User;
use Modules\User\Models\UserSocial;
use System\Core\Controllers\WebController;
use Socialite;

class AuthController extends WebController
{
    public function getLoginAdmin(Request $request)
    {
        if (auth('admin')->check())
            return redirect()->route('dashboard');
        return view('User::admin.login');
    }

    /**
     * Login admincp
     */
    public function postLoginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Chưa nhập email',
            'password.required' => 'Chưa nhập mật khẩu'
        ]);

        $is_remember = $request->has('is_remember') ? true : false;

        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $is_remember)) {
            if (auth('admin')->user()->status == 0) {
                auth('admin')->logout();
                session()->flush();
                $errors = [
                    'loginfaild' => 'Tài khoản của bạn đang bị khóa.'
                ];
            } else {
                if (!check_permission('dashboard')) {
                    auth('admin')->logout();
                    session()->flush();
                    $errors = [
                        'loginfaild' => 'Tài khoản không hợp lệ hoặc không có quyền truy cập.'
                    ];
                } else {
                    if ($request->redirect_to)
                        return redirect()->to(base64_decode($request->redirect_to));
                    return redirect()->route('dashboard');
                }
            }
        } else {
            $errors = [
                'loginfaild' => 'Thông tin đăng nhập không chính xác.'
            ];
        }
        return redirect()->route('mod_user.admin.login')->withInput()->withErrors($errors);
    }

    public function getLogoutAdmin()
    {
        if (auth('admin')->check()) {
            auth('admin')->logout();
            session()->flush();
        }
        return redirect()->route('mod_user.admin.login');
    }

    /**
     * Redirect the user to the Github authentication page
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Github
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $userSocial = UserSocial::where('social_id', $socialUser['id'])->where('provider', $provider)->first();
            if (auth('web')->check()) {
                if ($userSocial) {
                    $result = json_encode([
                        'status' => false,
                        'message' => 'Tài khoản MXH này đã được liên kết trên hệ thống trước đó.'
                    ]);
                    return view('User::web.callback_login_social', compact('result'));
                } else {
                    UserSocial::create([
                        'user_id' => auth('web')->id(),
                        'provider' => $provider,
                        'social_id' => $socialUser['id'],
                        'name' => $socialUser['name']
                    ]);
                    $result = json_encode([
                        'status' => true,
                        'message' => 'Liên kết tài khoản MXH thành công.'
                    ]);
                    return view('User::web.callback_login_social', compact('result'));
                }
            } else {
                if ($userSocial) {
                    $user = User::find($userSocial['user_id']);
                    auth('web')->login($user);
                    $result = json_encode([
                        'status' => true,
                        'message' => 'Đăng nhập thành công.'
                    ]);
                    return view('User::web.callback_login_social', compact('result'));
                } else {
                    $result = json_encode([
                        'status' => false,
                        'message' => 'Tài khoản MXH chưa được liên kết. Hãy đăng nhập bằng email và liên kết MXH trong phần thiết lập tài khoản.'
                    ]);
                    return view('User::web.callback_login_social', compact('result'));
                }
            }
        } catch (\Throwable $th) {
            $result = json_encode([
                'status' => false,
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'
            ]);
            return view('User::web.callback_login_social', compact('result'));
        }
    }
}