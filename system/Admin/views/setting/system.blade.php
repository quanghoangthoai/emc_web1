@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-cogs mr-2"></i> <span class="font-weight-semibold">Thiết lập hệ thống</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('cms.admin.postsetting_system') }}" method="post" id="formSetting">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered table-td-middle">
            <colgroup>
                <col style="width:25%">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <td><strong>Máy chủ mail</strong></td>
                    <td>
                        <input name="mail_host" type="text" class="form-control" value="{{ old('mail_host', cms_get_config('mail_host')) }}" placeholder="smtp.gmail.com">
                    </td>
                </tr>
                <tr>
                    <td><strong>Cổng gửi mail</strong></td>
                    <td>
                        <input name="mail_port" type="text" class="form-control" value="{{ old('mail_port', cms_get_config('mail_port')) }}" style="width:75px" placeholder="587">
                    </td>
                </tr>
                <tr>
                    <td><strong>Loại mã hóa</strong></td>
                    <td>
                        <select name="mail_encryption" class="form-control">
                            <option value="">Không</option>
                            <option value="ssl" {{ old('mail_encryption', cms_get_config('mail_encryption')) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="tls" {{ old('mail_encryption', cms_get_config('mail_encryption')) == 'tls' ? 'selected' : '' }}>TLS</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Tài khoản</strong></td>
                    <td>
                        <input name="mail_username" type="text" class="form-control" value="{{ old('mail_username', cms_get_config('mail_username')) }}" placeholder="user@gmail.com">
                    </td>
                </tr>
                <tr>
                    <td><strong>Mật khẩu</strong></td>
                    <td>
                        <input name="mail_password" type="password" class="form-control" value="{{ old('mail_password', cms_get_config('mail_password')) }}" placeholder="Mật khẩu">
                    </td>
                </tr>
                <tr>
                    <td><strong>Định danh người gửi</strong></td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <input name="mail_from_name" type="text" class="form-control" value="{{ old('mail_from_name', cms_get_config('mail_from_name')) }}" placeholder="EMC">
                            </div>
                            <div class="col-md-6">
                                <input name="mail_from_address" type="text" class="form-control" value="{{ old('mail_from_address', cms_get_config('mail_from_address')) }}" placeholder="user@gmail.com">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Kiểm tra cấu hình gửi mail</strong></td>
                    <td>
                        <div class="input-group">
                            <input name="test_email" type="text" class="form-control" placeholder="Nhập địa chỉ mail nhận tin">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-dark btn-sm" type="button" onclick="sendTestConfigMail();"><i class="fas fa-paper-plane mr-2"></i>Gửi</button>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="text-center mt-3">
        <button type="submit" class="btn btn-info">Lưu thay đổi</button>
    </div>
</form>
@endsection
@section('custom_js')
<script>
    function sendTestConfigMail()
    {
        var card_el = $('body');
        $(card_el).block({
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxSendTestConfigMail') }}",
            data: $('#formSetting').serialize(),
            dataType: 'json',
            success: function(res) {
                $(card_el).unblock();
                if (res.status) {
                    app.showNotify(res.message, 'success');
                } else {
                    app.showNotify(res.message, 'error');
                }
            }
        });
    }
</script>
@endsection
