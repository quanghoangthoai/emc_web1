@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-users mr-2"></i> <span class="font-weight-semibold">Quyền hạn</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>

    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="javascript:;" onclick="startSyncPermissions();" class="btn btn-primary btn-sm mr-1"><i class="icon-sync mr-1"></i> Đồng bộ quyền hạn</a>
            <a href="{{ route('cms.admin.list_role') }}" class="btn btn-warning float-right btn-sm">Quản lý vai trò</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div id="cardContentPermission">
    <div class="card-body list_permissions pt-0">
        @foreach (get_list_permissions() as $mod)
        <div class="mb-0 rounded-0">
            <h6 class="card-title mt-3">
                <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-{{ $mod['module'] }}" aria-expanded="true"><strong><i class="{{ $mod['icon'] }}"></i>&nbsp;&nbsp;{{ $mod['title'] }}</strong></a>
            </h6>

            <div id="collapsible-{{ $mod['module'] }}" class="collapse show">
                <div class="row">
                    @foreach ($mod['permissions'] as $permission)
                    <div class="col-md-3">
                        <p class="item_permission" data-popup="tooltip" title="{{ $permission['description'] }}">
                            <strong>{{ $permission['title'] }}</strong>
                            <br>
                            <em><small>{{ $permission['name'] }}</small></em>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('custom_js')
<script>
    function startSyncPermissions(el)
    {
        var card_el = $('body');
        $(card_el).block({
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxsyncpermissions') }}",
            data: {
                _token: _token
            },
            dataType: 'JSON',
            success: function(res) {
                setTimeout(function(){
                    $(card_el).unblock();
                }, 500);
                if (res.status) {
                    $('.list_permissions').html(res.html);
                    $('.item_permission[data-popup="tooltip"]').tooltip();
                    app.showNotify(res.msg, 'success');
                } else {
                    app.showNotify(res.msg, 'error');
                }
            }
        });
    }
</script>
@endsection
