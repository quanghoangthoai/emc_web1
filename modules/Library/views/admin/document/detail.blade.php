@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="icon-tree7 mr-2"></i> <span class="font-weight-semibold">Thư viện</span> - Tài liệu
            #{{ $doc['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <a href="{{ route('mod_library.admin.get_add_document') }}" class="btn btn-success">THÊM TÀI LIỆU</a>
</div>
@endsection
@section('custom_css')
<style>
    .col-form-label {
        font-weight: bold;
    }

    .select-date-input .form-control[readonly] {
        background-color: #ffffff
    }

    .picker__holder {
        right: 20px
    }
</style>
@endsection
@section('page_content')

<div class="row ml-0 mr-0" style="border-bottom: 1px solid #ddd">
    <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tên tài liệu <sup class="text-danger">(*)</sup></label>
                <div class="col-sm-10">
                    <input type="text" readonly placeholder="Nhập tên tài liệu" class="form-control" name="name" value="{{ old('name',$doc['name']) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label"><strong>Liên kết tĩnh</strong> <sup class="text-danger">(*)</sup></label>
                <div class="col-lg-10">
                    <div class="input-group">
                        <input placeholder="Nhập liên kết tĩnh" readonly id="txtSlug" type="text" class="form-control" name="slug" value="{{ old('slug', $doc['slug']) }}">
                        {{-- <div class="input-group-prepend mr-0">
                            <a readonly href="javascript:;" onclick="get_slug('#txtTitle', '#txtSlug');" class="btn btn-dark btn-sm"><em class="fa fa-sync"></em></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tệp tin tài liệu</label>
                <div class="col-sm-10">
                    <div class="input-group areaBrowserFile">
                        <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="doc-file" class="form-control" name="attach_file" value="{{ old('attach_file', $doc['attach_file']) }}">
                        <div class="input-group-prepend mr-0">

                            <a target="_blank" href="{{ route('mod_library.admin.get_download', $doc['id']) }}" class="btn btn-dark btn-sm"><i class="fa fa-image mr-1"></i> Tải file</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mô tả ngắn gọn</label>
                <div class="col-sm-10">
                    <textarea readonly placeholder="Nhập mô tả ngắn gọn" name="short_description" class="form-control" rows="5">{{ old('short_description', $doc['short_description']) }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Hình ảnh</label>
                <div class="col-sm-10">
                    <div class="input-group areaBrowserFile">
                        <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="doc-image" class="form-control" name="image" value="{{ old('image', $doc['image']) }}">
                        <div class="input-group-prepend mr-0">

                            <a href="{{asset($doc['image'])}}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-image mr-1"></i> Xem ảnh</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-12 col-form-label">
                    Nội dung chi tiết
                </label>
                <div class="col-lg-12">
                    <textarea placeholder="Nhập nội dung chi tiết" id="content" name="content">{{ old('content', $doc['content']) }}</textarea>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('mod_library.admin.get_list_document') }}" class="btn btn-primary">Quay lại</a>
            </div>

        </div>
    </div>
    <div class="col-md-4 p-0">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">Danh mục <sup class="text-danger">(*)</sup></label>
                <div class="col-sm-12">
                    <select disabled class="form-control" name="category_id">
                        <option value="">Chọn danh mục</option>
                        @if ($listCat && count($listCat) > 0)
                        @foreach ($listCat as $k => $iCategory)
                        <option value="{{ $iCategory['id'] }}" {{ old('category_id',$doc['category_id']) == $iCategory['id'] ? 'selected' : '' }}>{{$iCategory['prefix']}} {{ $iCategory['name'] }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">Loại <sup class="text-danger">(*)</sup></label>
                <div class="col-sm-12">
                    <select disabled class="form-control" id="document-type-select" name="document_type">
                        <option value="">{{ mod_library_get_document_type($doc['document_type']) }}</option>

                    </select>
                </div>
            </div>



            <hr>
            {{-- Extend when change Document Type --}}
            @if($doc['document_type'] == '1')
            <div id="document-extend-text">
                <div class="form-group row">
                    <input type="text" hidden name='doc_type_flag' value="text">
                    <label class="col-sm-5 col-form-label">Số hiệu</label>
                    <div class="col-sm-7">
                        <input readonly value="{{ old('text_code', isset($doc['text_code']) ? $doc['text_code'] : '')}}" type="text" placeholder="Nhập số hiệu" class="form-control" name="text_code">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Loại văn bản</label>
                    <div class="col-sm-7">
                        <select disabled class="form-control" name="text_type">
                            <option selected disabled>Chọn văn bản</option>
                            @if (mod_library_list_text_type())
                            @foreach (mod_library_list_text_type() as $key => $value)
                            <option value="{{ $key }}" {{ old('text_type', isset($doc['text_type']) ? $doc['text_type'] : '' ) ==  $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Ngày ban hành</label>
                    <div class="col-sm-7">
                        <input readonly value="{{ old('issued_date', isset($doc['issued_date']) ? mod_library_format_date($doc['issued_date'], 'd-m-Y') : '' )}}" type="text" class="form-control" name="issued_date" id="issued-date-picker">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Nơi ban hành</label>
                    <div class="col-sm-7">
                        <input readonly value="{{ old('issued_location', isset($doc['issued_location']) ? $doc['issued_location'] : '')}}" type="text" placeholder="Nhập nơi ban hành" class="form-control" name="issued_location">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Ngày hiệu lực</label>
                    <div class="col-sm-7">
                        <input readonly value="{{ old('started_date', isset($doc['started_date']) ? mod_library_format_date($doc['started_date'], 'd-m-Y') : '' )}}" type="text" class="form-control" name="started_date" id="started-date-picker">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Ngày hết hiệu lực</label>
                    <div class="col-sm-7">
                        <input readonly value="{{ old('expired_date', isset($doc['expired_date']) ? mod_library_format_date($doc['expired_date'], 'd-m-Y') : '' )}}" type="text" class="form-control" name="expired_date" id="expired-date-picker">
                    </div>
                </div>

            </div>
            @elseif($doc['document_type'] == 5)
            <div style="display:none" id="document-extend-video">
                <input type="text" readonly hidden name='doc_type_flag' value="video">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Link video</sup></label>
                    <div class="col-sm-7">
                        <input value="{{ old('video_url', isset($doc['video_url']) ? $doc['video_url'] : '')}}" type="text" class="form-control" name="video_url">
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection

@section('custom_js')
{{-- <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script> --}}
<script src="{{ asset('assets/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('content', {
        language: 'vi',
        height: 400,
        filebrowserBrowseUrl: '/file-manager/ckeditor',
        
    });
    CKEDITOR.instances.content.config.readOnly = true;
</script>

@endsection