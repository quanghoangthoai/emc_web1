@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-envelope mr-2"></i> <span class="font-weight-semibold">Liên hệ</span> - Cấu hình</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <form action="{{ route('mod_contact.admin.postconfig') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-form-label col-lg-12"><strong>Nội dung tại trang liên hệ</strong></label>
            <div class="col-lg-12">
                <textarea id="content" name="description" class="form-control">{{ old('description', cms_get_config('description', '', 'Contact')) }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-info">Lưu thay đổi</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('custom_js')
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 400,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })

    });
</script>
@endsection
