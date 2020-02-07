@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="icon-tree7 mr-2"></i> <span class="font-weight-semibold">Thư viện</span> - Tài liệu #{{ $doc['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>

    </div>
    <a href="{{ route('mod_library.admin.get_list_document') }}" class="btn btn-success">DANH SÁCH TÀI LIỆU</a>
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

{{-- text --}}
@section('page_content')
<form action="{{ route('mod_library.admin.post_edit_document',$doc['id']) }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0" style="border-bottom: 1px solid #ddd">
        <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tên tài liệu <sup class="text-danger">(*)</sup></label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Nhập tên tài liệu" id="txtTitle" class="form-control" name="name" value="{{ old('name',$doc['name']) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><strong>Liên kết tĩnh</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input placeholder="Nhập liên kết tĩnh" id="txtSlug" type="text" class="form-control" name="slug" value="{{ old('slug', $doc['slug']) }}">
                            <div class="input-group-prepend mr-0">
                                <a href="javascript:;" onclick="get_slug('#txtTitle', '#txtSlug');" class="btn btn-dark btn-sm"><em class="fa fa-sync"></em></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tệp tin tài liệu</label>
                    <div class="col-sm-10">
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn tệp" readonly type="text" id="doc-file" class="form-control" name="attach_file" value="{{ old('attach_file', $doc['attach_file']) }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="doc-file" type="button"><i class="fa fa-image mr-1"></i> Chọn tệp</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mô tả ngắn gọn</label>
                    <div class="col-sm-10">
                        <textarea placeholder="Nhập mô tả ngắn gọn" name="short_description" class="form-control" rows="5">{{ old('short_description', $doc['short_description']) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Hình ảnh</label>
                    <div class="col-sm-10">
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="doc-image" class="form-control" name="image" value="{{ old('image', $doc['image']) }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="doc-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-12 col-form-label">
                        Nội dung chi tiết
                    </label>
                    <div class="col-lg-12">
                        <textarea placeholder="Nhập nội dung chi tiết" id="content" name="content">{{ old('content',$doc['content']) }}</textarea>
                    </div>
                </div>
                {{-- Extend when change Document Type --}}
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Sửa tài liệu</button>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Danh mục <sup class="text-danger">(*)</sup></label>
                    <div class="col-sm-12">
                        <select class="form-control" name="category_id">
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
                        <select class="form-control" id="document-type-select" name="document_type">
                            <option value="">Chọn loại tài liệu</option>
                            <option value="">Chọn loại tài liệu</option>
                            @if(mod_library_list_document_type())
                            @foreach (mod_library_list_document_type() as $key => $value)
                            <option value="{{ $key }}" {{ old('document_type', $doc['document_type']) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Trạng thái</label>
                    <div class="col-sm-12">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $doc['status']) == 1 ? 'checked' : '' }} value="1">
                                    </div>
                                </div>
                                <span class="text-success">Hoạt động</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $doc['status']) == 0 ? 'checked' : '' }} value="0">
                                    </div>
                                </div>
                                <span class="text-danger">Tạm ngưng</span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>

                <div style="display:none" id="document-extend-text">
                    @include('Library::admin.document.component.fetch-text')
                </div>

                <div style="display:none" id="document-extend-video">
                    @include('Library::admin.document.component.fetch-video')
                </div>

            </div>
        </div>
    </div>
</form>

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
        filebrowserBrowseUrl: '/file-manager/ckeditor'
    });
</script>
<script>
    $( document ).ready(function() {
        var selVal = $("#document-type-select option:selected").val();
        load_extend(selVal);
    });
    function load_extend(selectedIndex){
        // $.ajax({
        //     url: '{{ route('mod_library.ajax.fetchExtend') }}',
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     dataType: 'json',
        //     method: "POST",
        //     data: {'docType': selectedIndex},
        //     success: function (data) {
        //         $('#document-extend-content').html(data.html);

        //     }
        // });
        switch (selectedIndex) {
            case '1':
                $('#document-extend-text').show();
                $('#document-extend-video').hide();
                break;
            case '5':
                $('#document-extend-video').show();
                $('#document-extend-text').hide();
                break;
        
            default:
                $('#document-extend-text').hide();
                $('#document-extend-video').hide();
                break;
        }
    }
    $("#document-type-select").on('change', function () {
        // For unique choice
        var selVal = $("#document-type-select option:selected").val();
        load_extend(selVal);
        
    });
    
    
</script>
@endsection