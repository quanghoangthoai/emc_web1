@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-comment mr-2"></i> <span class="font-weight-semibold">Bình luận</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card">
    <div class="card-header border-bottom mb-0 header-elements-inline p-0">
        <div class="text-center" style="margin-top: 20px!important;width: 100%;padding-left: 10px;padding-right: 10px;">
            <form action="{{ route('mod_comment.admin.list_comment') }}" method="GET">
                <div class="row">
                    <div class="col-12 col-md-6 mt-1">
                        <div class="form-group">
                            <input type="text" placeholder="Nhập nội dung tìm kiếm" class="form-control" name="title" value="{{ isset($filterdata['title']) ? $filterdata['title'] : '' }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mt-1">
                        <input autocomplete="off" name="created_at" type="text" class="form-control daterange-basic" value="{{ isset($filterdata['created_at']) ? $filterdata['created_at'] : '' }}">
                    </div>
                    <div class="col-12 col-md-2 mt-1 mb-1">
                        <button type="submit" class="btn btn-info"><i class="fas fa-filter mr-2"></i>Lọc</button>
                        <a href="{{ route('mod_comment.admin.list_comment') }}" class="btn">Xóa</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (isset($listCommment) && count($listCommment))
    <div class="table-responsive">
        <table class="table">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width:10px">STT</th>
                    <th class="text-center" style="width:180px">Thuộc Module</th>
                    <th class="text-center">Nội dung</th>
                    <th class="text-center" style="width:180px">Người bình luận</th>
                    <th class="text-center" style="width:180px">Thời gian bình luận</th>
                    <th class="text-center" style="width:120px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listCommment as $key => $iCom)
                <tr>
                    <td class="text-center">{{ $key+1 }}
                    </td>
                    <td class="text-center"><strong style="color: #2196f3"><a href="{{ $iCom['link'] }}">{{ $iCom['commentable_type'] }}</a></strong></td>
                    <td>{!! $iCom['body'] !!}</td>
                    <td class="text-center">
                        @if ($iCom['user_parent_id'] == null) {{ user_display_name($iCom['user_id']) }} @else {{ user_display_name($iCom['user_parent_id']) }} @endif
                    </td>
                    <td class="text-center">{{ date('H:i:s d-m-Y', strtotime($iCom['created_at'])) }}</td>
                    <td class="text-center">
                        <a href="{{ $iCom['link'] }}" class="text-primary" data-popup="tooltip" title="Xem chi tiết"><i class="fas fa-list-alt"></i></a>
                        <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{ route('mod_comment.admin.deltete_comment', $iCom['id']) }}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if ($listCommment->links('vendor.pagination.bootstrap-4'))
        <div class="cms-paginate text-center">
            {{ $listCommment->links('vendor.pagination.bootstrap-4') }}
        </div>
        @endif
    </div>
    @else
    <div class="col-12 mt-2">
        <div class="alert alert-info">Không tìm thấy dữ liệu</div>
    </div>
    @endif
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