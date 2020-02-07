@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-cubes mr-2"></i> <span class="font-weight-semibold">Quản lý module</span> "{{ $module['name'] }}" <small>({{ $module['version'] }})</small></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <form action="{{ route('cms.admin.postedit_module', $module['name']) }}" method="post">
        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-form-label col-lg-2"><strong>Tên module</strong> <sup class="text-danger">(*)</sup></label>
            <div class="col-lg-10">
                <input type="text" name="title" class="form-control" value="{{ old('title', $module['title']) }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2"><strong>Icon</strong></label>
            <div class="col-lg-10">
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $module['icon']) }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2"><strong>Mô tả</strong></label>
            <div class="col-lg-10">
                <input type="text" name="description" class="form-control" value="{{ old('description', $module['description']) }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-lg-2"><strong>Kích hoạt</strong></label>
            <div class="col-lg-10">
                <div class="form-check form-check-switchery">
                    <label class="form-check-label">
                        <input name="status" type="checkbox" class="form-check-input-switchery" {{ old('status', $module['status']) == 1 || old('status', $module['status']) == 'on' ? 'checked' : '' }} data-fouc>
                    </label>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('cms.admin.list_module') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="icon-check mr-1"></i> Lưu lại</button>
        </div>
    </form>
</div>
<!-- /form inputs -->
@endsection
