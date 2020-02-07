@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-users mr-2"></i> <span class="font-weight-semibold">Vai trò</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>

    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{ route('cms.admin.add_role') }}" class="btn btn-primary btn-sm">Thêm vai trò</a>
            <a href="{{ route('cms.admin.list_permission') }}" class="btn-sm btn btn-warning float-right ml-1">Quản lý quyền hạn</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
@if (isset($listRole) && count($listRole) > 0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="text-center" style="width:100px">STT</th>
                <th class="text-center">Mã vai trò</th>
                <th class="text-center">Tiêu đề</th>
                <th style="width:35%">Mô tả</th>
                <th style="width:150px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listRole as $iRole)
            <tr>
                <td class="text-center">
                    <select data-min="{{ $minOrder }}" data-max="{{ $maxOrder }}" data-order="{{ $iRole['order'] }}" data-id="{{ $iRole['id'] }}" class="form-control changOrder"></select>
                </td>
                <td class="text-center">{{ $iRole['name'] }}</td>
                <td class="text-center">{{ $iRole['title'] ? $iRole['title'] : '-' }}</td>
                <td>{{ $iRole['description'] ? $iRole['description'] : '-' }}</td>
                <td class="text-center">
                    @if ($iRole['name'] != 'superadmin')
                    <a href="{{ route('cms.admin.edit_role', $iRole['id']) }}" class="text-info"><i class="fa fa-edit"></i></a>
                    @if (!in_array($iRole['name'], ['staff', 'customer', 'applicant']))
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('cms.admin.delete_role', $iRole['id']) }}" class="text-danger"><i class="fa fa-trash"></i></a>
                    @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="p-3">
    <div class="alert alert-info">Không có dữ liệu</div>
</div>
@endif
@endsection

@section('custom_js')
<script>
    $(document).ready(function(){
        $(document).find('.changOrder').each(function() {
            var min = $(this).data('min');
            var max = $(this).data('max');
            var selected = $(this).data('order');
            var html = '';
            for (var i = min; i <= max; i++) {
                html += '<option value="' + i + '" ' + (i == selected ? 'selected' : '') + '>' + i + '</option>';
            }
            $(this).attr('onchange', 'change_order(this);return false;');
            $(this).html(html);
        });
    });

    function change_order(el)
    {
        var id = $(el).data('id');
        var order = $(el).val();
        // call ajax to chang order
        $(document).find('.changOrder').attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajax_change_order_role') }}",
            data: {
                _token: _token,
                id: id,
                order: order
            },
            dataType: 'JSON',
            success: function(data) {
                window.location.reload();
            }
        });
    }
</script>
@endsection
