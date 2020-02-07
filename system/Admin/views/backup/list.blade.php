@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-database mr-2"></i> <span class="font-weight-semibold">Sao lưu dữ liệu</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>

    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{ route('cms.admin.run_backup') }}" class="btn btn-sm btn-warning mb-2">Tạo bản sao lưu mới</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
@if ($listBackup)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Tên tệp sao lưu</th>
                <th class="text-center">Tạo lúc</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listBackup as $k => $iBackup)
            <tr>
                <td class="text-center">{{ $k + 1 }}</td>
                <td class="text-center">{{ $iBackup['filename'] }}</td>
                <td class="text-center"><em data-popup="tooltip" title="{{ $iBackup['created_at'] }}">{{ cms_time_elapsed_string($iBackup['created_at']) }}</em></td>
                <td class="text-center">
                    {{-- <a href="#" class="text-warning" data-popup="tooltip" title="Khôi phục dữ liệu"><i class="fa fa-redo mr-2"></i></a> --}}
                    <a href="{{ route('cms.admin.download_backup',$iBackup['filename']) }}" class="text-info" data-popup="tooltip" title="Tải về"><i class="fa fa-download mr-2"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);" data-href="{{ route('cms.admin.delete_backup',$iBackup['filename']) }}" class="text-danger" data-popup="tooltip" title="Xóa bỏ"><i class="fa fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="card-body">
    <div class="alert alert-info">Chưa có bản sao lưu nào.</div>
</div>
@endif
@endsection
