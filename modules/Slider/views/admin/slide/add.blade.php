@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Slide</span> - Thêm</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_slide.admin.list_slide')}}" class="btn btn-primary btn-sm">Danh sách slide</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_slide.admin.add_slide') }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0">
        <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Tiêu đề</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input id="txtTitle" name="title" value="{{ old('title') }}" type="text" class="form-control" placeholder="Nhập tiêu đề">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Hình ảnh slide</strong><sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="page-image" class="form-control" name="image" value="{{ old('image') }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="page-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Mô tả ngắn</strong></label>
                    <div class="col-lg-9">
                        <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả ngắn">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Nội dung nút liên kết</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input id="" name="button_text" value="{{ old('button_text') }}" type="text" class="form-control" placeholder="Nhập text button">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Đường dẫn liên kết</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input id="" name="link" value="{{ old('link') }}" type="text" class="form-control" placeholder="Nhập đường dẫn url">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0">
            <div class="card-body">
                <div class="form-group">
                    <label><strong>Thuộc khối</strong> <sup class="text-danger">(*)</sup></label>
                    <select name="block_id" class="form-control">
                        <option value="">-- Chưa chọn --</option>
                        @if (isset($listBlock) && count($listBlock))
                        @foreach ($listBlock as $block)
                        <option value="{{ $block['id'] }}" {{ old('block_id') == $block['id'] ? 'selected' : '' }}>{{ $block['name'] }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Trạng thái</strong></label>
                    <div class="col-lg-9">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', 1) == 1 ? 'checked' : '' }} value="1">
                                    </div>
                                </div>
                                <span class="text-success">Hiển thị</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', 1) == 0 ? 'checked' : '' }} value="0">
                                    </div>
                                </div>
                                <span class="text-danger">Ẩn</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <a href="{{ route('mod_slide.admin.list_slide') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                    <button type="submit" class="btn btn-info btn-sm">Thêm slide</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('custom_js')

@endsection