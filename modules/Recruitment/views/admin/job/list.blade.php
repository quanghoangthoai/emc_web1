@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-briefcase mr-2"></i><span class="font-weight-semibold">Tin tuyển dụng</span> - Danh sách</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_recruitment.admin.add_job')}}" class="btn btn-primary btn-sm">Đăng tin mới</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body pb-0">
    <form action="{{ route('mod_recruitment.admin.list_job') }}" method="GET">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <input type="text" placeholder="Nhập tiêu đề" class="form-control" name="title" value="{{ isset($filterdata['title']) ? $filterdata['title'] : '' }}">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="-1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == -1 ? 'selected' : '' }}>Tất cả trạng thái</option>
                        <option value="1" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == 1 ? 'selected' : '' }}>Hiện ngoài site</option>
                        <option value="0" {{ (isset($filterdata['status']) ? $filterdata['status'] : -1) == 0 ? 'selected' : '' }}>Không hiện</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <input autocomplete="off" name="created_at" type="text" class="form-control daterange-basic" value="{{ isset($filterdata['created_at']) ? $filterdata['created_at'] : '' }}">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-info"><i class="fas fa-filter mr-2"></i>Lọc</button>
                <a href="{{ route('mod_recruitment.admin.list_job') }}" class="btn">Xóa</a>
            </div>
        </div>
    </form>
</div>
@if($listJob && count($listJob) > 0)
<div class="table-responsive">
    <table class="table">
        <thead class="bg-light">
            <tr>
                <th class="text-center" style="width:100px">Thứ tự</th>
                <th>Tiêu đề</th>
                <th class="text-center">Vị trí</th>
                <th class="text-center">Mức lương</th>
                <th class="text-center">Hiện ngoài site</th>
                <th class="text-center">Đăng lúc</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listJob as $iJob)
            <tr>
                <td class="text-center">
                    <span style="display:none;">{{ $iJob['order'] }}</span>
                    <select data-min="{{ $minOrder }}" data-max="{{ $maxOrder }}" data-order="{{ $iJob['order'] }}" data-id="{{ $iJob['id'] }}" class="form-control changOrderPage"></select>
                </td>
                <td>
                    <a href="{{ route('mod_recruitment.admin.test', $iJob['id']) }}"><strong>{{ $iJob['title'] }}</strong></a>
                </td>
                <td class="text-center">{{ $iJob['position'] }}</td>
                <td class="text-center">{{ $iJob['salary'] }}</td>
                <td class="text-center">
                    <span style="display:none;">{{ $iJob['status'] }}</span>
                    <div class="form-check form-check-switchery form-check-switchery-sm">
                        <label class="form-check-label">
                            <input data-id="{{ $iJob['id'] }}" type="checkbox" class="form-input-switchery" {{ $iJob['status'] ? 'checked' : '' }}>
                        </label>
                    </div>
                </td>
                <td class="text-center">{{ date('H:i:s, d/m/Y', strtotime($iJob['created_at'])) }}</td>
                <td class="text-center">
                    <a href="{{ route('mod_recruitment.admin.edit_job', $iJob['id']) }}" class="text-warning mr-2" data-popup="tooltip" title="Sửa"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="askToDelete(this);return false;" data-href="{{route('mod_recruitment.admin.delete_job', $iJob['id'])}}" class="text-danger" data-popup="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($listJob->links('vendor.pagination.bootstrap-4'))
    <hr class="m-0">
    <div class="cms-paginate text-center">
        {{ $listJob->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif
</div>
@else
<div class="card-body">
    <div class="alert alert-info">Không tìm thấy tin tuyển dụng nào .</div>
</div>
@endif
@endsection

@section('custom_js')
<script src="{{ asset('assets/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.daterange-basic').daterangepicker({
            autoApply: true,
            autoUpdateInput: true,
            startDate: '{{ isset($filterdata["begindate"]) ? $filterdata["begindate"] : "" }}' == '' ? moment().add(-30, 'day') : '{{ isset($filterdata["begindate"]) ? $filterdata["begindate"] : "" }}',
            endDate: '{{ isset($filterdata["enddate"]) ? $filterdata["enddate"] : "" }}' == '' ? moment() : '{{ isset($filterdata["enddate"]) ? $filterdata["enddate"] : "" }}',
            locale: {
                format: 'DD/MM/YYYY'
            }
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
                            url: "{{ route('mod_recruitment.ajax.changeStatus') }}",
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
                            url: "{{ route('mod_recruitment.ajax.changeStatus') }}",
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

    $('.changOrderPage').each(function() {
        var min = $(this).data('min');
        var max = $(this).data('max');
        var selected = $(this).data('order');
        var id = $(this).data('id');
        var html = '';
        for (var i = min; i <= max; i++) {
            html += '<option value="' + i + '" ' + (i == selected ? 'selected' : '') + '>' + i + '</option>';
        }
        $(this).attr('onchange', 'change_order(this);return false;');
        $(this).html(html);
    });

    function change_order(el)
    {
        var id = $(el).data('id');
        var order = $(el).val();
        // call ajax to chang order
        $(document).find('.changOrderPage').attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: "{{ route('mod_recruitment.ajax.changeJob') }}",
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
