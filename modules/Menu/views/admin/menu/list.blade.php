@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Khối menu </span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{ route('mod_menu.admin.add_menu') }}" class="btn btn-primary btn-sm">Thêm khối menu</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
@if (count($listMenu) > 0)
<div class="card table-responsive">
    <table class="table table-striped table-bordered table-hover table-td-middle">
        <thead>
            <tr>
                <th class="text-center">Khối menu</th>
                <th class="text-center">Menu trực thuộc</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listMenu as $menu)
            <tr>
                <td class="text-center">
                    <a href="{{ route('mod_menu.admin.list_menu_item', $menu['id']) }}"><strong>{{ $menu['title'] }}</strong></a>
                </td>
                <td class="text-center">
                    @foreach ($menu['listItem'] as $item)
                    {{ $item['title'] }}&nbsp;&nbsp;
                    @endforeach
                </td>
                <td class="text-center">
                    <a href="{{ route('mod_menu.admin.edit_menu', $menu['id'])  }}" class="text-warning mr-2" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_menu.admin.delete_menu', $menu['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="card-body">
    <div class="alert alert-info">
        Chưa có dữ liệu
    </div>
</div>
@endif
@endsection