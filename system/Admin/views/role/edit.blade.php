@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-users mr-2"></i> <span class="font-weight-semibold">Vai trò</span> - Sửa #{{ $role['id'] }}</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('cms.admin.post_edit_role', $role['id']) }}" method="post">
    {{ csrf_field() }}
    <div class="card-body">
        <fieldset class="mt-3">
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Tiêu đề</strong> <sup class="text-danger">(∗)</sup></label>
                <div class="col-lg-9">
                    <input placeholder="Nhập tiêu đề" id="txtTitle" type="text" class="form-control" name="title" value="{{ old('title', $role['title']) }}" {{ in_array($role['name'], ['staff', 'customer', 'applicant']) ? 'readonly' : '' }}>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Mã vai trò</strong> <sup class="text-danger">(∗)</sup></label>
                <div class="col-lg-9">
                    <div class="input-group">
                        @if (!in_array($role['name'], ['staff', 'customer', 'applicant']))
                        <input placeholder="Nhập mã vai trò" id="txtSlug" type="text" class="form-control" name="name" value="{{ old('name', $role['name']) }}">
                        <div class="input-group-append">
                            <a href="javascript:;" onclick="get_slug('#txtTitle', '#txtSlug');" class="btn btn-outline-secondary btn-sm"><em class="fa fa-sync"></em></a>
                        </div>
                        @else
                        <input placeholder="Nhập mã vai trò" readonly type="text" class="form-control" name="name" value="{{ old('name', $role['name']) }}">
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Mô tả</strong></label>
                <div class="col-lg-9">
                    <input placeholder="Nhập mô tả" type="text" class="form-control" name="description" value="{{ old('description', $role['description']) }}">
                </div>
            </div>
        </fieldset>
    </div>

    <h5 class="text-center m-0">CHỌN QUYỀN HẠN</h5>
    <div class="card-body list_permissions">
        @foreach (get_list_permissions() as $mod)
        <div class="mb-0 rounded-0">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-{{ $mod['module'] }}" aria-expanded="true"><strong><i class="{{ $mod['icon'] }}"></i>&nbsp;&nbsp;{{ $mod['title'] }}</strong></a>
            </h6>

            <div id="collapsible-{{ $mod['module'] }}" class="collapse show">
                <div class="row">
                    @foreach ($mod['permissions'] as $permission)
                    <div class="col-md-3">
                        <div class="form-check" data-popup="tooltip" title="{{ $permission['description'] }}">
                            <label class="form-check-label item_permission">
                                <input name="permissions[]" value="{{ $permission['name'] }}" type="checkbox" class="form-check-input-styled" {{ in_array($permission['name'], old('permissions', $role['arr_permissions'])) ? 'checked' : '' }}>
                                <strong>{{ $permission['title'] }}</strong>
                                <br>
                                <em><small>{{ $permission['name'] }}</small></em>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center">
        <a href="{{ route('cms.admin.list_role') }}" class="btn-sm btn btn-dark">Hủy bỏ</a>
        <button class="btn-sm btn btn-info">Lưu lại</button>
    </div>
</form>
@endsection
@section('custom_js')
<script>
    $(document).ready(function(){
    var old_permissions = {!! json_encode(old('permissions', $role['arr_permissions'])) !!};
        old_permissions.forEach(function(e){
            $('input[value="' + e + '"]').prop("checked", true);
            $('input[value="' + e + '"]').parent().parent().parent().addClass('selected');
        })
        $.uniform.update();
});
</script>
@endsection
