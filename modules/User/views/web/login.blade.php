<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    @include('Web::partials.head_link')
</head>

<body>
    <div id="wrapper">
        <main id="main">
            <div id="content" role="main" class="content-area">
                <div class="container-fluid p-0">
                    <section id="login-form">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 f-login-img"></div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-flogin">
                                <div class="wrap-login100">
                                    <form class="login100-form validate-form" onsubmit="ajax_login(this, true);return false;" data-action="{{ route('post_login') }}">
                                        @csrf
                                        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', request()->input('redirect_to')) }}">
                                        <figure class="text-center">
                                            <img src="{{ asset($global_config['site_logo'] ?? 'assets/web/images/logo-emc.png') }}" alt="{{ $global_config['site_name'] }}" style="width:50%">
                                        </figure>
                                        <span class="login100-form-title">
                                            Đăng nhập
                                        </span>

                                        <div class="wrap-input100 validate-input">
                                            <input class="input100" type="text" name="email" placeholder="Email">
                                            <span class="focus-input100"></span>
                                            <span class="symbol-input100">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="wrap-input100 validate-input">
                                            <input class="input100" type="password" name="password" placeholder="Mật khẩu">
                                            <span class="symbol-input100">
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_remember" value="1" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Ghi nhớ mật khẩu.
                                            </label>
                                        </div>
                                        <div class="container-login100-form-btn">
                                            <span id="resultLoginMessage" class="mt-1 mb-1" style="display:none;"></span>
                                            <button class="login100-form-btn" type="submit">
                                                Đăng nhập
                                            </button>
                                        </div>
                                        <div class="text-center p-t-12">
                                            <a class="txt2" href="#">
                                                Quên mật khẩu?
                                            </a>
                                        </div>

                                        @if ($global_config['enable_login_facebook'] || $global_config['enable_login_google'])
                                        <hr>
                                        <div class="text-center p-t-221">
                                            <p>Đăng nhập bằng mạng xã hội - <span style="color: #ed3237; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Dành cho thành viên đã kết nối ID với Google hoặc Facebook">Lưu ý</span></p>
                                        </div>
                                        <div class="login-social">
                                            @if ($global_config['enable_login_facebook'])
                                            <a onclick="login_social('{{ route('login.social', 'facebook') }}');" href="javascript:;" class="lg-facebook">
                                                <span><i class="fab fa-facebook-f"></i>Facebook</span>
                                            </a>
                                            @endif
                                            @if ($global_config['enable_login_google'])
                                            <a onclick="login_social('{{ route('login.social', 'google') }}');" href="javascript:;" class="lg-google">
                                                <span><i class="fab fa-google"></i>Google</span>
                                            </a>
                                            @endif
                                        </div>
                                        @endif

                                        <div class="text-center p-t-136">
                                            <a class="txt2" href="registration.html">
                                                Tạo tài khoản mới <span><i class="fas fa-long-arrow-alt-right"></i></span>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
    @include('Web::partials.foot_script')
</body>

</html>
