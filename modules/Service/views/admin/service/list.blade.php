@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-cube mr-2"></i> <span class="font-weight-semibold">Dịch vụ</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_service.admin.add_service')}}" class="btn btn-primary btn-sm">Thêm dịch vụ</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div class="card">
    <div class="card-header border-bottom mb-0 header-elements-inline p-0">
        <div class="text-center" style="margin-top: 20px!important;width: 100%;padding-left: 10px;padding-right: 10px;">
            <form action="{{ route('mod_service.admin.list_service') }}" method="GET">
                <div class="row">
                    <div class="col-12 col-md-6 mt-1">
                        <div class="form-group">
                            <input type="text" placeholder="Nhập nội dung tìm kiếm" class="form-control" name="name" value="{{ isset($filterdata['name']) ? $filterdata['name'] : '' }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mt-1">
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="-1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == -1 ? 'selected' : '' }}>Tất cả trạng thái</option>
                                @if (mod_service_list_status())
                                @foreach (mod_service_list_status() as $key => $value)
                                <option value="{{ $key }}" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == $key ? 'selected' : '' }}>{{$value}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 mt-1 mb-1">
                        <button type="submit" class="btn btn-info"><i class="fas fa-filter mr-2"></i>Lọc</button>
                        <a href="{{ route('mod_service.admin.list_service') }}" class="btn">Xóa</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ($listService && count($listService) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width:100px;">Thứ tự</th>
                    <th>Tên dịch vụ</th>
                    <th class="text-center">Danh mục</th>
                    <th class="text-center" style="width:150px;">Trạng thái</th>
                    <th class="text-center" style="width:120px;"><i class="fa fa-eye"></i></th>
                    <th class="text-center" style="width:150px;">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($listService as $iService)
                <tr>
                    <td class="text-center">
                        <span style="display:none;">{{ $iService['order'] }}</span>
                        <input type="number" data-id="{{ $iService['id'] }}" value="{{ $iService['order'] }}" class="form-control changOrder" onchange="change_order(this);">
                    </td>
                    <td>
                        <a target="_blank" href="{{ route('home') }}/{{ $iService['slug'] }}"><strong>{{ $iService['name'] }}</strong></a>
                    </td>
                    <td class="text-center">
                        {{ $iService->category['name'] }}
                    </td>
                    <td class="text-center">
                        <span style="display:none;">{{ $iService['status'] }}</span>
                        <div class="form-check form-check-switchery form-check-switchery-sm">
                            <label class="form-check-label">
                                <input data-id="{{ $iService['id'] }}" type="checkbox" class="form-input-switchery" {{ $iService['status'] ? 'checked' : '' }}>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">{{ $iService['totalhits'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('mod_service.admin.edit_service',$iService['id']) }}" class="text-warning mr-1" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_service.admin.delete_service',$iService['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if ($listService->links('vendor.pagination.bootstrap-4'))
        <div class="cms-paginate text-right mb-3">
            {{ $listService->links('vendor.pagination.bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
@else
<div class="col-12 mt-2">
    <div class="alert alert-info">Chưa có dịch vụ nào được thêm</div>
</div>
@endif
@endsection

@section('custom_js')
<script src="{{asset('assets/admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script>
    function change_order(el)
    {
        var id = $(el).data('id');
        var order = $(el).val();
        // call ajax to chang order
        $(document).find('.changOrder').attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: "{{ route('mod_service.admin.ajaxChangeOrderService') }}",
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
    $(document).ready( function () {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }
        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                sInfo:"Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                search: '<span>Tìm kiếm:</span> _INPUT_',
                searchPlaceholder: 'Nhập tìm kiếm...',
                lengthMenu: '<span>Hiển thị:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });
        $('.data-table').DataTable({
            order: [[0, "asc" ]],
            columnDefs: [
                {targets: [5], searchable: false, orderable: false, visible: true }
            ]
        });

        var switches = Array.prototype.slice.call(document.querySelectorAll('.form-input-switchery'));
        switches.forEach(function (html) {
            var switchery = new Switchery(html, {
                secondaryColor: '#d8201c'
            });
        });
        var inProcess = false;
        $(document).find('.form-input-switchery').each(function (i, html) {
            $(html).on('click', function(e){
                if (!inProcess) {
                    if (typeof $(this).attr('checked') !== typeof undefined) {
                        // 1 => 0
                        inProcess = true;
                        $.ajax({
                            type: 'post',
                            url: "{{ route('mod_service.ajax.changeStatusService') }}",
                            data: {
                                _token: _token,
                                id: $(this).data('id'),
                                status: 0
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                inProcess = false;
                                if (res.status) {
                                    $(html).removeAttr('checked');
                                    app.showNotify(res.msg, 'success');
                                } else {
                                    app.showNotify(res.msg, 'error');
                                    setTimeout(function(){
                                        var newEl = new Switchery(html, {
                                            secondaryColor: '#d8201c'
                                        });
                                        setSwitchery(newEl, true);
                                    }, 200);
                                }
                            }
                        });
                    }
                    if (typeof $(this).attr('checked') === typeof undefined) {
                        // 0 => 1
                        inProcess = true;
                        $.ajax({
                            type: 'post',
                            url: "{{ route('mod_service.ajax.changeStatusService') }}",
                            data: {
                                _token: _token,
                                id: $(this).data('id'),
                                status: 1
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                inProcess = false;
                                if (res.status) {
                                    $(html).attr('checked', 'checked');
                                    app.showNotify(res.msg, 'success');
                                } else {
                                    app.showNotify(res.msg, 'error');
                                    setTimeout(function(){
                                        var newEl = new Switchery(html, {
                                            secondaryColor: '#d8201c'
                                        });
                                        setSwitchery(newEl, false);
                                    }, 200);
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