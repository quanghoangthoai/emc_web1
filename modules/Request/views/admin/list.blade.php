@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Yêu Cầu</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_request.admin.add_request')}}" class="btn btn-primary btn-sm">Tạo yêu cầu</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body pb-0">
    <form action="{{ route('mod_request.admin.list_request') }}" method="GET">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <input type="text" placeholder="Nhập tên khách hàng" class="form-control" name="client_name" value="{{ isset($filterdata['client_name']) ? $filterdata['client_name'] : '' }}">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="-1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == -1 ? 'selected' : '' }}>Tất cả trạng thái</option>
                        @if (mod_request_list_status())
                        @foreach (mod_request_list_status() as $key => $value)
                        <option value="{{ $key }}" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == 1 ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <input autocomplete="off" name="created_at" type="text" class="form-control daterange-basic" value="{{ isset($filterdata['created_at']) ? $filterdata['created_at'] : '' }}">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-info"><i class="fas fa-filter mr-2"></i>Lọc</button>
                <a href="{{ route('mod_request.admin.list_request') }}" class="btn">Xóa</a>
            </div>
        </div>
    </form>
</div>
@if (count($listRequest) > 0)
<div class="table-responsive">
    <table class="table datatable-basic">
        <thead class="bg-light">
            <tr>

                <th class="text-center">ID</th>
                <th class="text-center">Thông tin khách hàng</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Gửi yêu cầu lúc</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listRequest as $iReq)
            <tr>
                <td class="text-center">{!! $iReq['id'] !!}</td>
                <td class="text-center"><a href="{{ route('mod_request.admin.edit_request', $iReq['id']) }}"><strong>{{ $iReq['client_name'] }}</strong></a>
                </td>
                <td class="text-center">{!! mod_request_get_status($iReq['status']) !!}</td>
                <td class="text-center">{{ $iReq['created_at'] }}</td>
                <td class="text-center">
                    @if($iReq['isOrderCreated'])
                    <a href="{{ route('mod_request.admin.detail_request', $iReq['id']) }}" class="text-warning mr-2" data-popup="tooltip" title="Xem chi tiết"><i class="fa fa-list"></i></a>
                    @else
                    <a href="{{ route('mod_request.admin.edit_request', $iReq['id']) }}" class="text-warning mr-2" data-popup="tooltip" title="Xem chi tiết"><i class="fa fa-list"></i></a>
                    {{-- <a href="javascript:;" onclick="askToDelete(this);return false;"
                        data-href="{{ route('mod_request.admin.delete_request', $iReq['id']) }}" class="text-danger"
                    data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a> --}}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($listRequest->links('vendor.pagination.bootstrap-4'))
    <div class="cms-paginate float-right mr-3">
        {{ $listRequest->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif
</div>
@else
<div class="card-body">
    <div class="alert alert-info">
        Chưa có dữ liệu
    </div>
</div>
@endif
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