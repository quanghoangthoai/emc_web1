@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-cubes mr-2"></i> <span class="font-weight-semibold">Quản lý module</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
{{-- INSTALLED --}}
@if ($listInstalledModules && count($listInstalledModules) > 0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th colspan="7" class="text-success"><i class="fa fa-check mr-1"></i> ĐÃ CÀI ĐẶT</th>
            </tr>
            <tr>
                <th class="text-center" style="width:100px;">Thứ tự</th>
                <th class="text-center">Module</th>
                <th class="text-center">Tên module</th>
                <th class="text-center">Mô tả</th>
                <th class="text-center">Phiên bản</th>
                <th class="text-center">Kích hoạt</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listInstalledModules as $i => $iMod)
            <tr>
                <td class="text-center">
                    <select data-min="{{ $minOrder }}" data-max="{{ $maxOrder }}" data-order="{{ $iMod['order'] }}" data-name="{{ $iMod['name'] }}" class="form-control changOrder"></select></td>
                <td class="text-center">{{ $iMod['name'] }}</td>
                <td class="text-center"><i class="{{ $iMod['icon'] }} mr-1"></i> <strong>{{ $iMod['title'] }}</strong></td>
                <td>{{ $iMod['description'] }}</td>
                <td class="text-center">{{ $iMod['version'] }}</td>
                <td class="text-center">
                    <div class="form-check form-check-switchery" style="display: inline-block;">
                        <label class="form-check-label">
                            <input data-name="{{ $iMod['name'] }}" name="status" type="checkbox" class="form-check-input-switchery" {{ $iMod['status'] == 1 ? 'checked' : '' }} data-fouc {{ $iMod['name'] == 'User' ? 'disabled' : '' }}>
                        </label>
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{ route('cms.admin.edit_module', $iMod['name']) }}" data-popup="tooltip" title="Quản lý" class="text-info"><i class="fa fa-edit"></i></a>
                    @if ($iMod['name'] != 'User')
                    <a href="javascript:;" onclick="askToUninstallMod(this);" data-href="{{ route('cms.admin.uninstall_module', $iMod['name']) }}" data-popup="tooltip" title="Gỡ cài đặt" class="text-danger ml-2"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- NOT INSTALL --}}
@if ($not_install_modules && is_array($not_install_modules) && count($not_install_modules) > 0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th colspan="7" class="text-danger"><i class="fa fa-list mr-1"></i> CHƯA CÀI ĐẶT</th>
            </tr>
            <tr>
                <th class="text-center" style="width:100px;">#</th>
                <th class="text-center">Module</th>
                <th class="text-center">Tên module</th>
                <th class="text-center">Mô tả</th>
                <th class="text-center">Phiên bản</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($not_install_modules as $i => $iMod)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td class="text-center">{{ $iMod['name'] }}</td>
                <td class="text-center">{{ $iMod['title'] }}</td>
                <td>{{ $iMod['description'] }}</td>
                <td class="text-center">{{ $iMod['version'] }}</td>
                <td class="text-center">
                    <a href="{{ route('cms.admin.install_module', $iMod['name']) }}" data-popup="tooltip" title="Cài đặt"><i class="fa fa-cog"></i></a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endif
@endsection

@section('custom_js')
<script>
    function change_order(el)
    {
        var mod = $(el).data('name');
        var order = $(el).val();
        // call ajax to chang order
        $(document).find('.changOrder').attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxChangeOrderModule') }}",
            data: {
                _token: _token,
                mod: mod,
                order: order
            },
            dataType: 'JSON',
            success: function(data) {
                window.location.reload();
            }
        });
    }
    $('document').ready(function () {
        $('.changOrder').each(function() {
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

        var inProcess = false;
        $(document).find('.form-check-input-switchery').each(function (i, html) {
            $(html).on('click', function(e){
                if (!inProcess) {
                    if (typeof $(this).attr('checked') !== typeof undefined) {
                        // 1 => 0 //
                        inProcess = true;
                        $.ajax({
                            type: 'post',
                            url: "{{ route('cms.admin.ajaxchangestatus_module') }}",
                            data: {
                                _token: _token,
                                name: $(this).data('name'),
                                status: 0
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                inProcess = false;
                                if (res.status) {
                                    $(html).removeAttr('checked');
                                    app.showNotify(res.message, 'success');
                                } else {
                                    app.showNotify(res.message, 'error');
                                }
                            }
                        });
                    }
                    if (typeof $(this).attr('checked') === typeof undefined) {
                        // 0 => 1 //
                        inProcess = true;
                        $.ajax({
                            type: 'post',
                            url: "{{ route('cms.admin.ajaxchangestatus_module') }}",
                            data: {
                                _token: _token,
                                name: $(this).data('name'),
                                status: 1
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                inProcess = false;
                                if (res.status) {
                                    $(html).attr('checked', 'checked');
                                    app.showNotify(res.message, 'success');
                                } else {
                                    app.showNotify(res.message, 'error');
                                }
                            }
                        });
                    }
                } else {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection
