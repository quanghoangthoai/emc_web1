<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập{{ isset($global_config['site_name']) ? ' | ' . $global_config['site_name'] : '' }}</title>
    @include('Admin::layouts.partials.head_link')

    <style>
        .bg-login {
            background: url("{{ asset('images/bg-login-admin.jpg') }}");
            background-size: cover;
            height: 100vh;
            background-position: bottom;
        }

        .login-right {
            position: relative;
            height: 100%;
        }

        .login-form {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            width: 24rem;
        }

        .login-form .img-logo {
            width: 200px;
            max-width: 100%;
        }

        .form-control-feedback {
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <div class="row ml-0 mr-0">
        <div class="col-md-6 p-0">
            <div class="bg-login"></div>
        </div>
        <div class="col-md-6 p-0">
            <div class="login-right">
                <!-- Login form -->
                <form class="login-form" action="{{ route('mod_user.admin.post_login') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="redirect_to" value="{{ old('redirect_to', request()->input('redirect_to')) }}">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="{{ asset('images/logo-emc.png') }}" alt="Logo" class="img-logo">
                                <hr>
                            </div>

                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input autocomplete="new-password" name="email" value="{{ old('email') }}" type="text" class="form-control" placeholder="Nhập email">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input autocomplete="new-password" name="password" type="password" class="form-control" placeholder="Nhập mật khẩu">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <div class="form-check mb-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="is_remember" class="form-check-input-styled">
                                        Ghi nhớ
                                    </label>
                                </div>

                                <a href="javascript:;" onclick="alert('Tính năng đang phát triển');" class="ml-auto">Quên mật khẩu?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">ĐĂNG NHẬP <i class="icon-circle-right2 ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /login form -->
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/ui/ripple.min.js') }}"></script>
    <!-- /core JS files -->

    <script src="{{ asset('assets/js.cookie.min.js') }}"></script>

    <script src="{{ asset('assets/admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/forms/styling/switch.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/js/noty.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dev.custom.js') }}"></script>
    <!-- /theme JS files -->
    <script>
        $(document).ready(function(){
        $('.form-check-input-styled').uniform();

        @if (isset($errors) && count($errors->all()) > 0)
            @foreach ($errors->all() as $message)
                app.showNotify("{{ $message }}", "error");
            @endforeach
        @endif

        @if(session('flash_data'))
            @php
                $flash_data = session('flash_data');
            @endphp
            app.showNotify("{{ $flash_data['message'] }}", "{{ $flash_data['type'] }}");
        @endif
    });
    </script>

</body>

</html>
