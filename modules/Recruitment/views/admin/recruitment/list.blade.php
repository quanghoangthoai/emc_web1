@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-user-tie mr-2"></i> <span class="font-weight-semibold">Danh Sách</span> - Ứng Viên</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body pb-0">
    <form action="{{ route('mod_recruitment.admin.list_recruitment') }}" method="GET">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <input type="text" placeholder="Nhập tên ứng viên" class="form-control" name="fullname" value="{{ isset($filterdata['fullname']) ? $filterdata['fullname'] : '' }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <select class="form-control select2" name="job_id">
                        <option value="-1" {{ (isset($filterdata['job_id']) ? $filterdata['job_id'] : -1) == -1 ? 'selected' : '' }}>Tất cả tin tuyển dụng</option>
                        @if ($listJob && $listJob->count() > 0)
                        @foreach ($listJob as $iJob)
                        <option value="{{ $iJob['id'] }}" {{ (isset($filterdata['job_id']) ? $filterdata['job_id'] : -1) == $iJob['id'] ? 'selected' : '' }}>#{{ $iJob['id'] }} - {{ $iJob['title'] }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="-1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == -1 ? 'selected' : '' }}>Tất cả trạng thái</option>
                        @if (mod_recruitment_list_status())
                        @foreach (mod_recruitment_list_status() as $key => $value)
                        <option value="{{ $key }}" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == 1 ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <input autocomplete="off" name="created_at" type="text" class="form-control daterange-basic" value="{{ isset($filterdata['created_at']) ? $filterdata['created_at'] : '' }}">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-info"><i class="fas fa-filter mr-2"></i>Lọc</button>
                <a href="{{ route('mod_recruitment.admin.list_recruitment') }}" class="btn">Xóa</a>
            </div>
        </div>
    </form>
</div>
@if($listRec && count($listRec) > 0)
<div class="table-responsive">
    <table class="table">
        <thead class="bg-light">
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Ứng viên</th>
                <th class="text-center">Tin tuyển dụng</th>
                <th class="text-center">Gửi lúc</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listRec as $iRec)
            <tr>
                <td class="text-center">{{ $iRec['id'] }}</td>
                <td class="text-center">
                    @if ($iRec->personal)
                    <a href="{{route('mod_recruitment.admin.detail_recruitment', $iRec['id'])}}"><strong>{{ $iRec->personal->info->fullname }}</strong></a>
                    @else
                    <em>Tài khoản đã bị xóa</em>
                    @endif

                </td>
                <td class="text-center"><a href="{{ route('mod_recruitment.admin.test', $iRec->job['id']) }}">#{{ $iRec->job['id'] }} - {{ $iRec->job['title'] }}</a></td>
                <td class="text-center">{{ $iRec['created_at'] }}</td>
                <td class="text-center">{!! mod_recruitment_get_status($iRec['status']) !!}</td>
                <td class="text-center">
                    <a href="{{route('mod_recruitment.admin.get_download', $iRec['id'])}}" class="text-info mr-2" data-popup="tooltip" title="Tải hồ sơ"><i class="fa fa-download"></i></a>
                    <a href="{{route('mod_recruitment.admin.detail_recruitment', $iRec['id'])}}" class="text-warning mr-2" data-popup="tooltip" title="Xem chi tiết"><i class="fa fa-list"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{route('mod_recruitment.admin.delete_recruitment', $iRec['id'])}}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($listRec->links('vendor.pagination.bootstrap-4'))
    <hr class="m-0">
    <div class="cms-paginate text-center">
        {{ $listRec->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif
</div>
@else
<div class="card-body">
    <div class="alert alert-info">Không tìm thấy dữ liệu.</div>
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
