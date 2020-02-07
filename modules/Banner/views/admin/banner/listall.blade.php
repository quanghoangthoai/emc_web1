@extends('Admin::layouts.default')
@section('page_title', 'Quảng cáo')

@section('page_content')
@if (count($listBanner) > 0)
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Thuộc khối</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
                <th class="text-center">Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listBanner as $banner)
            <tr>
                <td>{{ $banner['title'] }}</td>
                <td>{{ $banner->block['title'] }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($banner['begin_time'])) }}</td>
                <td>{{ $banner['expired_time'] ? date('d/m/Y H:i:s', strtotime($banner['expired_time'])) : 'Không giới hạn' }}</td>
                <td class="text-center">{!! $banner['status'] ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<span class="text-danger"><i class="fa fa-close"></i></span>' !!}</td>
                <td class="text-center">
                    <a href="{{ route('mod_banner.admin.editbanner', $banner['id']) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Sửa</a>
                    <a href="javascript:;" onclick="askToDelete(this); return false;" data-href="{{ route('mod_banner.admin.deletebanner', $banner['id']) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info">Chưa có dữ liệu</div>
@endif
@endsection
