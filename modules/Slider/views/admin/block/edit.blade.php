@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Khu vực hiển thị</span> - Sửa</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_block.admin.list_block')}}" class="btn btn-primary btn-sm">Danh sách khối</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_block.admin.post_edit_block', $block['id']) }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Tiêu đề</strong> <sup class="text-danger">(*)</sup></label>
                <div class="col-lg-9">
                    <input name="name" value="{{ old('name', $block['name']) }}" type="text" class="form-control" placeholder="Nhập tiêu đề">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Mô tả ngắn</strong></label>
                <div class="col-lg-9">
                    <textarea name="description" rows="4" class="form-control" placeholder="Mô tả thiệu ngắn">{{ old('description', $block['description']) }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Trạng thái</strong></label>
                <div class="col-lg-9">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <div class="uniform-choice">
                                <div class="uniform-choice">
                                    <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $block['status']) == 1 ? 'checked' : '' }} value="1">
                                </div>
                            </div>
                            <span class="text-success">Hiển thị</span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <div class="uniform-choice">
                                <div class="uniform-choice">
                                    <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $block['status']) == 0 ? 'checked' : '' }} value="0">
                                </div>
                            </div>
                            <span class="text-danger">Ẩn</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="card-body">
        <div class="text-center">
            <a href="{{ route('mod_block.admin.list_block') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
            <button type="submit" class="btn btn-info btn-sm">Sửa khối</button>
        </div>
    </div>
    </div>
</form>
@endsection
@section('custom_js')

@endsection