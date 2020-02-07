@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-plug mr-2"></i> <span class="font-weight-semibold">Quản lý Addons</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<!-- Form inputs -->
<div class="card-body">
    <div class="alert alert-info alert-styled-left">
        Vui lòng nhập đầy đủ thông tin cấu hình khi bật các tính năng tiện ích nhằm tránh xảy ra lỗi trong quá trình vận hành hệ thống.
    </div>
    <form action="{{ route('cms.admin.post_addons') }}" method="post">
        {{ csrf_field() }}
        <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-vnpay" aria-expanded="true">
            <h6><strong class="text-teal"><i class="icon-qrcode mr-2"></i>TÍCH HỢP THANH TOÁN <span class="text-danger">VN</span><span class="text-primary">PAY</span></strong></h6>
        </a>
        <div id="collapsible-vnpay" class="collapse show">
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong></strong></label>
                <div class="col-lg-9">
                    <div class="form-check">
                        <label class="form-check-label text-teal">
                            <input name="enable_vnpay" value="1" type="checkbox" class="form-check-input-styled" {{ old('enable_vnpay', cms_get_config('enable_vnpay'))==1 ? 'checked' : '' }}>
                            Bật tính năng thanh toán bằng <strong><span class="text-danger">VN</span><span class="text-primary">PAY</span></strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Mã website</strong></label>
                <div class="col-lg-9">
                    <input name="vnpay_tmncode" type="text" class="form-control" placeholder="Nhập mã website" value="{{ cms_get_config('vnpay_tmncode') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Chuỗi bí mật</strong></label>
                <div class="col-lg-9">
                    <input name="vnpay_hashsecret" type="text" class="form-control" placeholder="Nhập chuỗi bí mật" value="{{ cms_get_config('vnpay_hashsecret') }}">
                </div>
            </div>

        </div>
        <hr>
        <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-facebook" aria-expanded="true">
            <h6><strong class="text-primary"><i class="fab fa-facebook mr-2"></i>ĐĂNG NHẬP BẰNG FACEBOOK</strong></h6>
        </a>
        <div id="collapsible-facebook" class="collapse show">
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong></strong></label>
                <div class="col-lg-9">
                    <div class="form-check">
                        <label class="form-check-label text-primary">
                            <input name="enable_login_facebook" value="1" type="checkbox" class="form-check-input-styled" {{ old('enable_login_facebook', cms_get_config('enable_login_facebook'))==1 ? 'checked' : '' }}>
                            Bật tính năng đăng nhập bằng <strong>FACEBOOK</strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>ID ứng dụng</strong></label>
                <div class="col-lg-9">
                    <input name="facebook_app_id" type="text" class="form-control" placeholder="Nhập ID ứng dụng" value="{{ cms_get_config('facebook_app_id') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Khóa bí mật</strong></label>
                <div class="col-lg-9">
                    <input name="facebook_app_secret" type="text" class="form-control" placeholder="Nhập khóa bí mật" value="{{ cms_get_config('facebook_app_secret') }}">
                </div>
            </div>
        </div>
        <hr>
        <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-google" aria-expanded="true">
            <h6><strong class="text-danger"><i class="fab fa-google mr-2"></i>ĐĂNG NHẬP BẰNG GOOGLE</strong></h6>
        </a>
        <div id="collapsible-google" class="collapse show">
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong></strong></label>
                <div class="col-lg-9">
                    <div class="form-check">
                        <label class="form-check-label text-danger">
                            <input name="enable_login_google" value="1" type="checkbox" class="form-check-input-styled" {{ old('enable_login_google', cms_get_config('enable_login_google'))==1 ? 'checked' : '' }}>
                            Bật tính năng đăng nhập bằng <strong>GOOGLE</strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>ID ứng dụng</strong></label>
                <div class="col-lg-9">
                    <input name="google_app_id" type="text" class="form-control" placeholder="Nhập ID ứng dụng" value="{{ cms_get_config('google_app_id') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Khóa bí mật</strong></label>
                <div class="col-lg-9">
                    <input name="google_app_secret" type="text" class="form-control" placeholder="Nhập khóa bí mật" value="{{ cms_get_config('google_app_secret') }}">
                </div>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-sm"><i class="icon-check mr-1"></i> Lưu lại</button>
        </div>
    </form>
</div>
@endsection
