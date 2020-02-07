@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-info-circle mr-2"></i> <span class="font-weight-semibold">Thông tin website</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<!-- Form inputs -->
<form action="{{ route('cms.admin.postsetting_info') }}" method="post">
    {{ csrf_field() }}
    <div class="card-body">
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>URL website</strong></label>
            <div class="col-lg-9">
                <input placeholder="Nhập URL website" type="text" name="site_url" class="form-control" value="{{ old('site_url', cms_get_config('site_url')) }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Tên website</strong> <sup class="text-danger">(*)</sup></label>
            <div class="col-lg-9">
                <input placeholder="Nhập tên website" type="text" name="site_name" class="form-control" value="{{ old('site_name', cms_get_config('site_name')) }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Logo</strong> <sup class="text-danger">(*)</sup></label>
            <div class="col-lg-9">
                <div class="input-group">
                    <input readonly type="text" id="img-logo" class="form-control" name="site_logo" aria-label="Image" aria-describedby="button-image" value="{{ old('site_logo', cms_get_config('site_logo')) }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-sm" data-id="img-logo" type="button" id="button-image"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Email</strong> <sup class="text-danger">(*)</sup></label>
            <div class="col-lg-9">
                <input placeholder="Nhập tên email" type="text" name="site_email" class="form-control" value="{{ old('site_email', cms_get_config('site_email')) }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Mô tả</strong></label>
            <div class="col-lg-9">
                <input placeholder="Nhập mô tả website" type="text" name="site_description" class="form-control" value="{{ old('site_description', cms_get_config('site_description')) }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Từ khóa máy chủ tìm kiếm</strong></label>
            <div class="col-lg-9">
                <input placeholder="Nhập từ khóa máy chủ tìm kiếm" type="text" name="site_keywords" class="form-control" value="{{ old('site_keywords', cms_get_config('site_keywords')) }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Điện thoại</strong></label>
            <div class="col-lg-9">
                <input placeholder="Nhập điện thoại" type="text" name="site_phone" class="form-control" value="{{ old('site_phone', cms_get_config('site_phone')) }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3"><strong>Địa chỉ</strong></label>
            <div class="col-lg-9">
                <input placeholder="Nhập địa chỉ" type="text" name="site_address" class="form-control" value="{{ old('site_address', cms_get_config('site_address')) }}">
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-sm"><i class="icon-check mr-1"></i> Lưu lại</button>
    </div>
</form>
<div id="modalSelectFile" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-full">
        <div class="modal-content" style="height:90vh">
            <div class="modal-header">
                <h5 class="modal-title">Chọn tệp tin</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:0 2px 10px;"></div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#button-image').on('click', (event) => {
            event.preventDefault();
            $('#modalSelectFile .modal-body').html('<iframe src="/file-manager/fm-button?id=' + $('#button-image').data('id') + '" frameborder="0" style="width:100%;height:100%"></iframe>');
            $('#modalSelectFile').modal('show');
        });
    });

    // set file link
    function fmSetLink($url, id = '') {
        document.getElementById(id).value = $url.replace(app_url, "");
        $('#modalSelectFile').modal('hide');
    }
</script>
@endsection
