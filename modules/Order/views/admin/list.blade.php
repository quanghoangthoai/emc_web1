@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fab fa-first-order mr-2"></i> <span class="font-weight-semibold">Đơn hàng</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection

@section('page_content')
<div class="card-body" style="padding: 0">
    <div class="card-header border-bottom mb-0 header-elements-inline p-0">
        <div class="text-center" style="margin-top: 20px!important;width: 100%;padding-left: 10px;padding-right: 10px;">
            <form action="#" method="GET">
                <div class="row">
                    <div class="col-12 col-md-4 mt-1">
                        <div class="form-group">
                            <input type="text" placeholder="Nhập nội dung tìm kiếm" class="form-control" name="order_id" value="{{ isset($filterdata['order_id']) ? $filterdata['order_id'] : '' }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 mt-1">
                        <div class="form-group">
                            <select class="form-control" name="status">
                                <option value="-1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == -1 ? 'selected' : '' }}>Tất cả trạng thái</option>
                                @if (mod_order_list_status())
                                @foreach (mod_order_list_status() as $key => $value)
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
                        <a href="{{ route('mod_order.admin.list') }}" class="btn">Xóa</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (isset($listOrder) && count($listOrder))
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width:120px">Mã đơn hàng</th>
                    <th>Thông tin khách hàng</th>
                    <th>Sản phẩm</th>
                    <th class="text-center" style="width:150px">Trạng thái</th>
                    <th>Nhân viên</th>
                    <th class="text-center" style="width:180px">Thời gian</th>
                    <th class="text-center" style="width:120px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listOrder as $iOrder)
                <tr>
                    <td class="text-center">
                        <p>{{ $iOrder['order_id'] }}</p>
                    </td>
                    <td>
                        @foreach (mod_order_get_info_customer($iOrder['request_id']) as $iCus)
                        <p>{!! $iCus !!}</p>
                        @endforeach
                    </td>
                    <td>
                        @foreach (mod_order_get_name_product($iOrder['request_id']) as $iPro)
                        <p>{{ $iPro['name'] }}</p>
                        @endforeach
                    </td>
                    <td class="text-center">
                        <p>{!! mod_order_get_html_status($iOrder['status']) !!}</p>
                    </td>
                    <td>
                        <p>{{ user_display_name($iOrder['staff_id']) }}</p>
                    </td>
                    <td class="text-center">
                        <p>{{ date('H:i:s d/m/Y', strtotime($iOrder[mod_order_get_time($iOrder['status'])])) }}</p>
                    </td>
                    <td class="text-center">
                        <p>
                            <a href="{{ route('mod_order.admin.order',$iOrder['request_id']) }}" class="text-warning" data-popup="tooltip" title="Xem chi tiết"><i class="fa fa-list"></i></a>
                            <a @if ($iOrder['status']==4) {!! 'style="visibility: hidden"' !!} @endif href="javascript:;" onclick="askToCancel(this);return false;" data-href="{{ route('mod_order.admin.cancel_order',$iOrder['id']) }}" class="text-danger" data-popup="tooltip" title="Hủy"><i class="fa fa-times"></i></a>
                        </p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if ($listOrder->links('vendor.pagination.bootstrap-4'))
        <div class="cms-paginate text-center mb-3">
            {{ $listOrder->links('vendor.pagination.bootstrap-4') }}
        </div>
        @endif
    </div>
    @else
    <div class="p-3">
        <div class="alert alert-info">
            Không tìm thấy dữ liệu
        </div>
    </div>
    @endif
</div>
@endsection

@section('custom_js')
<script>
    function askToCancel(element) {
    if (confirm("Bạn có chắc chắn muốn hủy đơn hàng này?")) {
        window.location.href = $(element).data("href");
    }
    return false;
}
</script>
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