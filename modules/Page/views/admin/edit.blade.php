@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Trang</span> - #{{ $page['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_page.admin.list_page')}}" class="btn btn-primary btn-sm">Danh sách trang</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_page.admin.post_edit_page', $page['id']) }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0">
        <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Tiêu đề</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input id="txtTitle" name="title" value="{{ old('title', $page['title']) }}" type="text" class="form-control" placeholder="Nhập tiêu đề">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Liên kết tĩnh</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <input placeholder="Nhập liên kết tĩnh" id="txtSlug" type="text" class="form-control" name="slug" value="{{ old('slug', $page['slug']) }}">
                            <div class="input-group-prepend mr-0">
                                <a href="javascript:;" onclick="get_slug('#txtTitle', '#txtSlug');" class="btn btn-dark btn-sm"><em class="fa fa-sync"></em></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Hình minh họa</strong></label>
                    <div class="col-lg-9">
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="page-image" class="form-control" name="image" value="{{ old('image', $page['image']) }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="page-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Giới thiệu ngắn</strong></label>
                    <div class="col-lg-9">
                        <textarea name="description" rows="4" class="form-control" placeholder="Nhập giới thiệu ngắn">{{ old('description', $page['description']) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Nội dung chi tiết</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <textarea id="content" name="content" rows="3" class="form-control">{{ old('content', $page['content']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Trạng thái</strong></label>
                    <div class="col-lg-9">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $page['status']) == 1 ? 'checked' : '' }} value="1">
                                    </div>
                                </div>
                                <span class="text-success">Xuất bản</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $page['status']) == 0 ? 'checked' : '' }} value="0">
                                    </div>
                                </div>
                                <span class="text-danger">Ẩn</span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-seo" aria-expanded="true">
                    <h6><strong><i class="fab fa-google mr-2"></i>CẤU HÌNH SEO</strong></h6>
                </a>
                <div id="collapsible-seo" class="collapse">
                    <div class="form-group">
                        <label><strong>Tiêu đề SEO</strong></label>
                        <input name="seo_title" type="text" class="form-control" placeholder="Nhập tiêu đề SEO" value="{{ old('seo_title', $page['seo_title']) }}">
                    </div>
                    <div class="form-group">
                        <label><strong>Mô tả SEO</strong></label>
                        <input name="seo_description" type="text" class="form-control" placeholder="Nhập mô tả SEO" value="{{ old('seo_description', $page['seo_description']) }}">
                    </div>
                    <div class="form-group">
                        <label><strong>Từ khóa SEO</strong></label>
                        <input name="seo_keywords" type="text" class="form-control" placeholder="Nhập từ khóa SEO" value="{{ old('seo_keywords', $page['seo_keywords']) }}">
                    </div>
                    <div class="form-group">
                        <label><strong>Hình ảnh SEO</strong></label>
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="seo-image" class="form-control" name="seo_image" value="{{ old('seo_image', $page['seo_image']) }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="seo-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-right">
                    <a href="{{ route('mod_page.admin.list_page') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                    <button type="submit" class="btn btn-info btn-sm">Lưu lại</button>
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
            height: 500,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        });
    });
</script>
@endsection
