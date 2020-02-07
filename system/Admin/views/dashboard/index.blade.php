@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="icon-home2 mr-2"></i> <span class="font-weight-semibold">Bảng điều khiển</span></h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>

    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="#" data-toggle="modal" data-target="#modalAdminWidgets" class="btn btn-dark font-size-sm font-weight-semibold legitRipple">
                <i class="icon-make-group"></i>
                <span class="ml-1">Quản lý widget</span>
            </a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            @widgetGroup('TOP')
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            @widgetGroup('LEFT')
        </div>
        <div class="col-md-6 col-12">
            @widgetGroup('RIGHT')
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @widgetGroup('BOTTOM')
        </div>
    </div>
</div>

<!-- Iconified modal -->
<div id="modalAdminWidgets" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;QUẢN LÝ WIDGET</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{ route('cms.admin.post_save_widget') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">TÊN WIDGET</th>
                                <th style="width: 10%;" class="text-center">TRẠNG THÁI</th>
                                <th>TIÊU ĐỀ</th>
                                <th>VỊ TRÍ</th>
                                <th style="width: 10%;" class="text-center">THỨ TỰ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($listWidget)
                            @foreach ($listWidget as $iWidget)
                            <tr>
                                <td>{!! '<small>[<strong>' . $iWidget['module'] . '</strong>]</small> '. $iWidget['name'] !!}</td>
                                <td class="text-center">
                                    <div class="form-check form-check-switchery" style="display: inline-block;">
                                        <label class="form-check-label">
                                            <input {{ $iWidget['status'] ? 'checked' : '' }} name="widget[{{ $iWidget['module'] }}][{{ $iWidget['name'] }}][status]" type="checkbox" class="form-check-input-switchery" data-fouc>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <input {{ $iWidget['status'] ? '' : 'readonly' }} name="widget[{{ $iWidget['module'] }}][{{ $iWidget['name'] }}][title]" type="text" value="{{ $iWidget['title'] }}" class="candisabled form-control">
                                </td>
                                <td>
                                    <select name="widget[{{ $iWidget['module'] }}][{{ $iWidget['name'] }}][group]" class="form-control">
                                        @foreach (config('Admin::widget.group') as $iGroup)
                                        <option value="{{ $iGroup }}" {{ $iGroup == $iWidget['group'] ? 'selected' : '' }}>{{ $iGroup }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <input {{ $iWidget['status'] ? '' : 'readonly' }} name="widget[{{ $iWidget['module'] }}][{{ $iWidget['name'] }}][order]" type="number" min="0" value="{{ $iWidget['order'] }}" class="candisabled form-control">
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn-sm btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Đóng</button>
                    <button type="submit" class="btn-sm btn bg-primary"><i class="icon-checkmark3 font-size-base mr-1"></i> Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /iconified modal -->
@endsection

@section('custom_js')
<script>
    $('document').ready(function () {
        $(document).find('.form-check-input-switchery').each(function (i, html) {
            $(html).on('click', function(e){
                if (typeof $(this).attr('checked') !== typeof undefined) {
                    $(this).parent().parent().parent().parent().find('input.candisabled').attr('readonly', 'readonly');
                    $(html).removeAttr('checked');
                    return true;
                }
                if (typeof $(this).attr('checked') === typeof undefined) {
                    $(this).parent().parent().parent().parent().find('input[readonly].candisabled').removeAttr('readonly');
                    $(html).attr('checked', 'checked');
                    return true;
                }
            });
        });
    });
</script>
@endsection
