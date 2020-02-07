@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-users mr-2"></i> <span class="font-weight-semibold">Thông báo</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
@if (count($listNotifications) > 0)
<form action="{{ route('cms.admin.bulkaction_notification') }}" method="post">
    {{ csrf_field() }}
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nội dung</th>
                    <th class="text-center">Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listNotifications as $notify)
                @if (empty($notify['read_at']))
                <tr style="font-weight: bold">
                    <td data-href="{{ isset($notify['data']['link']) ? $notify['data']['link'] : '' }}" data-id="{{ $notify['id'] }}" onclick="go_notify_item(this);return false;">{{ $notify['data']['message'] }}</td>
                    <td data-href="{{ isset($notify['data']['link']) ? $notify['data']['link'] : '' }}" data-id="{{ $notify['id'] }}" onclick="go_notify_item(this);return false;" class="text-center">{{ cms_time_elapsed_string($notify['created_at']) }}</td>
                </tr>
                @else
                <tr>
                    <td data-href="{{ isset($notify['data']['link']) ? $notify['data']['link'] : '' }}" data-id="{{ $notify['id'] }}" onclick="go_notify_item(this);return false;">{{ $notify['data']['message'] }}</td>
                    <td data-href="{{ isset($notify['data']['link']) ? $notify['data']['link'] : '' }}" data-id="{{ $notify['id'] }}" onclick="go_notify_item(this);return false;" class="text-center">{{ cms_time_elapsed_string($notify['created_at']) }}</td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <td colspan="4">
                        <button class="btn btn-info btn-sm" name="markRead" value="1"><i class="fa fa-check"></i> Đánh dấu đã xem tất cả</button>
                        <button class="btn btn-danger btn-sm" name="delAll" value="1"><i class="fa fa-trash"></i> Xóa tất cả</button>

                        @if ($listNotifications->links('vendor.pagination.bootstrap-4'))
                        <div class="cms-paginate float-right mt-0">
                            {{ $listNotifications->links('vendor.pagination.bootstrap-4') }}
                        </div>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</form>
@else
<div class="card-body">
    <div class="alert alert-info">
        Chưa có thông báo
    </div>
</div>
@endif
@endsection
@section('custom_css')
<style>
    tbody>tr>td {
        cursor: pointer;
    }
</style>
@endsection
