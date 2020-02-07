@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-ticket-alt mr-2"></i> <span class="font-weight-semibold">Yêu cầu hỗ trợ</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body" style="padding: 0">
    <div class="card">
        <div class="card-header border-bottom mb-0 header-elements-inline p-0">
            <div class="text-center" style="margin-top: 20px!important;width: 100%;padding-left: 10px;padding-right: 10px;">
                <form action="{{ route('mod_ticket.admin.list_ticket') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-4 mt-1">
                            <div class="form-group">
                                <input type="text" placeholder="Nhập nội dung tìm kiếm" class="form-control" name="title" value="{{ isset($filterdata['title']) ? $filterdata['title'] : '' }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mt-1">
                            <div class="form-group">
                                <select class="form-control" name="status">
                                    <option value="-1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == -1 ? 'selected' : '' }}>Tất cả trạng thái</option>
                                    @if (mod_ticket_list_status())
                                    @foreach (mod_ticket_list_status() as $key => $value)
                                    <option value="{{ $key }}" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == $key ? 'selected' : '' }}>{{$value}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mt-1">
                            <input autocomplete="off" name="created_at" type="text" class="form-control daterange-basic" value="{{ isset($filterdata['created_at']) ? $filterdata['created_at'] : '' }}">
                        </div>
                        <div class="col-12 col-md-2 mt-1 mb-1">
                            <button type="submit" class="btn btn-info"><i class="fas fa-filter mr-2"></i>Lọc</button>
                            <a href="{{ route('mod_ticket.admin.list_ticket') }}" class="btn">Xóa</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (isset($listTic) && count($listTic))
        <div class="table-responsive">
            <table class="table datatable-basic">
                <thead class="bg-light">
                    <tr>
                        <th style="display: none">id</th>
                        <th class="text-center" style="width:150px">Khách hàng</th>
                        <th class="text-center">Tiêu đề</th>
                        <th class="text-center" style="width:150px">Dịch vụ</th>
                        <th class="text-center" style="width:120px">Trạng thái</th>
                        <th class="text-center" style="width:160px">Ngày tạo</th>
                        <th class="text-center" style="width:160px">Phản hồi lần cuối</th>
                        <th class="text-center" style="width:120px">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listTic as $iTick)
                    <tr>
                        <td style="display: none">{{ $iTick['title'] }}</td>
                        <td class="text-center">{{ user_display_name($iTick['customer_id']) }}</td>
                        <td class="text-center">{{ $iTick['title'] }}</td>
                        <td class="text-center">{{ mod_ticket_get_name_product($iTick['product_id']) }}</td>
                        <td class="text-center">{!! mod_ticket_get_html_status($iTick['status']) !!}</td>
                        <td class="text-center"><span data-popup="tooltip" title="{{ $iTick['created_at'] }}">{{ date('H:i:s d/m/Y', strtotime($iTick['created_at'])) }}</span></td>
                        <td class="text-center"><span data-popup="tooltip" title="{{ $iTick['created_at'] }}">{{ date('H:i:s d/m/Y', strtotime(mod_ticket_get_last_reply($iTick['id']))) }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('mod_ticket.admin.detail_ticket', $iTick['id']) }}" class="text-warning" data-popup="tooltip" title="Xem chi tiết"><i class="fas fa-clipboard-list"></i></a>
                            <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_ticket.admin.delete_ticket', $iTick['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($listTic->links('vendor.pagination.bootstrap-4'))
            <div class="cms-paginate text-right mb-3">
                {{ $listTic->links('vendor.pagination.bootstrap-4') }}
            </div>
            @endif
        </div>
        @else
        <div class="col-12 mt-2">
            <div class="alert alert-info">Không tìm thấy dữ liệu</div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('custom_js')

<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('.daterange-basic').daterangepicker({
            autoApply: true,
            autoUpdateInput: true,
            startDate: '{{ isset($filterdata["begindate"]) ? $filterdata["begindate"] : "" }}' == '' ? moment().add(-30, 'day') : '{{ isset($filterdata["begindate"]) ? $filterdata["begindate"] : "" }}',
            endDate: '{{ isset($filterdata["enddate"]) ? $filterdata["enddate"] : "" }}' == '' ? moment() : '{{ isset($filterdata["enddate"]) ? $filterdata["enddate"] : "" }}',
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    });
</script>
@endsection