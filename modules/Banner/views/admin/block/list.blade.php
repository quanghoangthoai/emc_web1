@extends('Admin::layouts.default')
@section('page_title', 'Khối quảng cáo')

@section('page_content')
@if (count($listBlock) > 0)
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Kích thước</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Số lượng QC</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listBlock as $block)
            <tr>
                <td>{{ $block['title'] }}</td>
                <td>{{ $block['width'] }} x {{ $block['height'] }} px</td>
                <td class="text-center">{!! $block['status'] ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<span class="text-danger"><i class="fa fa-close"></i></span>' !!}</td>
                <td class="text-center">{{ $block->banners->count() }}</td>
                <td class="text-center">
                    <a href="{{ route('mod_banner.admin.editblock', $block['id']) }}" class="text-warning"><i class="fa fa-edit"></i> Sửa</a>
                    @if ($block['id'] != 1 && $block['id'] != 2)
                    <a href="javascript:;" onclick="askToDelete(this); return false;" data-href="{{ route('mod_banner.admin.deleteblock', $block['id']) }}" class="text-danger"><i class="fa fa-trash"></i> Xóa</a>
                    @endif
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
