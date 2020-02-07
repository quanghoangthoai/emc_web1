@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Tin tuyển dụng</span> - #{{ $editjob['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_recruitment.admin.list_job')}}" class="btn btn-primary btn-sm">Danh sách tin tuyển dụng</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_recruitment.admin.post_edit_job', $editjob['id']) }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0">
        <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Tiêu đề</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input id="txtTitle" name="title" value="{{ old('title', $editjob['title']) }}" type="text" class="form-control" placeholder="Nhập tiêu đề">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Liên kết tĩnh</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <input placeholder="Nhập liên kết tĩnh" id="txtSlug" type="text" class="form-control" name="slug" value="{{ old('slug', $editjob['slug']) }}">
                            <div class="input-group-prepend mr-0">
                                <a href="javascript:;" onclick="get_slug('#txtTitle', '#txtSlug');" class="btn btn-dark btn-sm"><em class="fa fa-sync"></em></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Vị trí tuyển dụng</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input name="position" value="{{ old('position', $editjob['position']) }}" type="text" class="form-control" placeholder="Nhập vị trí tuyển dụng">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Số người cần tuyển</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input name="people_number" value="{{ old('people_number', $editjob['people_number']) }}" type="number" min="1" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Hình thức làm việc</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input name="work_type" value="{{ old('work_type', $editjob['work_type']) }}" type="text" class="form-control" placeholder="Toàn thời gian, bán thời gian, thời vụ,...">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Mức lương</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input name="salary" value="{{ old('salary', $editjob['salary']) }}" type="text" class="form-control" placeholder="Nhập mức lương">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Hình minh họa</strong></label>
                    <div class="col-lg-9">
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="page-image" class="form-control" name="image" value="{{ old('image', $editjob['image']) }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="page-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Mô tả ngắn</strong></label>
                    <div class="col-lg-12">
                        <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả ngắn">{{ old('description', $editjob['description']) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Nội dung chi tiết</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <textarea id="content" name="content" rows="3" class="form-control">{{ old('content', $editjob['content']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Hạn chót nhận hồ sơ</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <input name="expired_at" value="{{ old('expired_at', $editjob['expired_at']) }}" type="text" class="form-control datepicker" placeholder="Chọn ngày">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Địa chỉ tuyển dụng</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <input name="work_address" value="{{ old('work_address', $editjob['work_address']) }}" type="text" class="form-control" placeholder="Nhập địa chỉ tuyển dụng">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Thông tin liên hệ</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <textarea name="contact_info" rows="3" class="form-control" placeholder="Nhập thông tin liên hệ">{{ old('contact_info', $editjob['contact_info']) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Website</strong></label>
                    <div class="col-lg-12">
                        <input name="link" value="{{ old('link', $editjob['link']) }}" type="text" class="form-control" placeholder="Nhập website">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-12"><strong>Hiện ngoài site</strong></label>
                    <div class="col-lg-12">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $editjob['status']) == 1 ? 'checked' : '' }} value="1">
                                    </div>
                                </div>
                                <span class="text-success">Hiển thị</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $editjob['status']) == 0 ? 'checked' : '' }} value="0">
                                    </div>
                                </div>
                                <span class="text-danger">Không hiển thị</span>
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
                        <input name="seo_title" type="text" class="form-control" placeholder="Nhập tiêu đề SEO" value="{{ old('seo_title', $editjob['seo_title']) }}">
                    </div>
                    <div class="form-group">
                        <label><strong>Mô tả SEO</strong></label>
                        <input name="seo_description" type="text" class="form-control" placeholder="Nhập mô tả SEO" value="{{ old('seo_description', $editjob['seo_description']) }}">
                    </div>
                    <div class="form-group">
                        <label><strong>Từ khóa SEO</strong></label>
                        <input name="seo_keywords" type="text" class="form-control" placeholder="Nhập từ khóa SEO" value="{{ old('seo_keywords', $editjob['keywords']) }}">
                    </div>
                    <div class="form-group">
                        <label><strong>Hình ảnh SEO</strong></label>
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="seo-image" class="form-control" name="seo_image" value="{{ old('seo_image', $editjob['seo_image']) }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="seo-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-right">
                    <a href="{{ route('mod_recruitment.admin.list_job') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                    <button type="submit" class="btn btn-info btn-sm">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('custom_js')
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            startDate: "{{ old('expired_at', date('d/m/Y', strtotime($editjob['expired_at']))) }}",
            locale: {
                format:"DD/MM/YYYY"
            }
        });

        CKEDITOR.replace('content',{
            language: 'vi',
            height: 500,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        });
    });
</script>
@endsection
