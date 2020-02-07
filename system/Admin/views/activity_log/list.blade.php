@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-history mr-2"></i> <span class="font-weight-semibold">Nhật ký hoạt động</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="javascript:;" onclick="askToDelete(this);" data-href="{{ route('cms.admin.delete_all_activity_log') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt mr-1"></i> Xóa toàn bộ</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Loại</th>
                <th class="text-center">Nội dung</th>
                <th class="text-center" style="width:30%">Chi tiết</th>
                <th class="text-center">Thực hiện bởi</th>
                <th class="text-center">Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listActivity as $iActivity)
            <tr>
                <td class="text-center">{{ $iActivity['id'] }}</td>
                <td class="text-center">{{ $iActivity['log_name'] }}</td>
                <td>{{ $iActivity['description'] }}</td>
                <td style="word-break: break-word;">{{ $iActivity['properties'] != '[]' ? $iActivity['properties'] : '' }}</td>
                <td class="text-center">{{ user_display_name($iActivity->causer['id']) }}</td>
                <td class="text-center"><em data-popup="tooltip" title="{{ $iActivity['created_at'] }}">{{ cms_time_elapsed_string($iActivity['created_at']) }}</em></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($listActivity->links('vendor.pagination.bootstrap-4'))
    <div class="cms-paginate text-center">
        {{ $listActivity->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif
</div>
@endsection
