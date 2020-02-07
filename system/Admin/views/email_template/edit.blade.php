@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-envelope mr-2"></i> <span class="font-weight-semibold">Mẫu email</span> - #{{ $email_tpl['id'] }} - {{ $email_tpl['title'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{ route('cms.admin.list_email_templates') }}" class="btn-sm btn btn-warning">Danh sách mẫu email</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('cms.admin.post_edit_email_template', $email_tpl['id']) }}" method="POST">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0">
        <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
            <div class="card-body">
                <div class="form-group row mb-0">
                    <label class="col-form-label col-lg-3"><strong>Tiêu đề</strong></label>
                    <div class="col-lg-9 col-form-label">
                        {{ $email_tpl['title'] }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Mô tả</strong></label>
                    <div class="col-lg-9 col-form-label">
                        {{ $email_tpl['description'] }}
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Tiêu đề email</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input name="mail_title" value="{{ old('mail_title', $email_tpl['mail_title']) }}" type="text" class="form-control" placeholder="Nhập tiêu đề email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>NỘI DUNG EMAIL</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <textarea id="content" name="mail_content" rows="3" class="form-control">{{ old('mail_content', $email_tpl['mail_content']) }}</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('cms.admin.list_email_templates') }}" class="btn btn-dark">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">LƯU LẠI</button>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0">
            <div class="card-body">
                <h6><strong>THAM SỐ ĐƯỢC DÙNG TRONG EMAIL NÀY</strong></h6>
                <div class="alert alert-info alert-sm">
                    Nhấp vào tham số để chèn vào nội dung email.
                </div>

                <div class="list-group list-group-bordered">
                    @foreach ($email_tpl['variables'] as $iVar)
                    <a href="javascript:;" onclick="insert_var_to_content('{{ $iVar['code'] }}')" class="list-group-item text-dark">
                        <strong>{{ $iVar['title'] }}</strong>
                        <span class="ml-auto text-primary">{{ $iVar['code'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('custom_js')
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 400,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        });
    });

    function insert_var_to_content(code) {
        CKEDITOR.instances.content.insertHtml(code);
    }
</script>
@endsection
