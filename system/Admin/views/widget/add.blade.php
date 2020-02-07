@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fas fa-th-list mr-2"></i> <span class="font-weight-semibold">Widget</span> - Thêm</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>

    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{ route('cms.admin.list_widget') }}" class="btn btn-primary btn-sm">Danh sách widget</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('cms.admin.post_add_widget') }}" method="post">
    {{ csrf_field() }}
    <div class="card">
        <table class="table table-bordered">
            <colgroup>
                <col class="w200">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <td><strong>Chọn widget</strong> <sup class="required">(*)</sup></td>
                    <td>
                        <select id="selectModule" onchange="load_widget_module(this);return false;" name="module" class="form-control input-inline w200">
                            <option value="">Chọn module</option>
                            @foreach (get_list_module_has_widget() as $mod)
                            <option value="{{ $mod['name'] }}">{{ $mod['title'] }}</option>
                            @endforeach
                        </select>
                        <select id="selectWidget" name="name" class="form-control input-inline w300" onchange="load_config();return false;"></select>
                    </td>
                </tr>
                <tr id="trConfig"></tr>
                <tr>
                    <td><strong>Tiêu đề</strong> <sup class="required">(*)</sup></td>
                    <td>
                        <input name="title" type="text" class="form-control w300" value="{{ old('title') }}">
                    </td>
                </tr>
                <tr>
                    <td><strong>URL của tiêu đề</strong></td>
                    <td>
                        <input name="link" type="text" class="form-control" value="{{ old('link') }}">
                    </td>
                </tr>
                <tr>
                    <td><strong>Template</strong> <sup class="required">(*)</sup></td>
                    <td>
                        <select name="template" class="form-control w200">
                            @foreach (get_list_template_widget() as $itpl)
                            <option value="{{ $itpl }}" {{ old('template') == $itpl ? 'selected' : '' }}>{{ $itpl }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Vị trí</strong> <sup class="required">(*)</sup></td>
                    <td>
                        <select name="position" class="form-control w200">
                            @foreach (config('widget.position') as $position)
                            <option value="{{ $position }}" {{ old('position') == $position ? 'selected' : '' }}>
                                {{ $position }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Kích hoạt</strong></td>
                    <td>
                        <input name="active" value="1" type="checkbox" class="minimal" {{ old('active', 1) ? 'checked' : '' }}>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-info">Thêm widget</button>
        </div>
    </div>
</form>
@endsection
@section('custom_js')
<script>
    function load_widget_module(el)
    {
        var module = $(el).val();
        $('#selectWidget').attr('disabled', 'disabled');
        $('#selectModule').attr('disabled', 'disabled');
        $.ajax({
            type: 'post',
            url: "{{ route('cms.admin.ajaxLoadWidgetModule') }}",
            data: {
                _token: _token,
                module: module
            },
            dataType: 'JSON',
            success: function(data) {
                var html = '';
                data.forEach(function(item){
                    html += '<option value="'+ item.value +'" data-hasconfig="' + item.hasConfig + '">'+ item.value +'</option>';
                });
                $('#selectWidget').html(html);
                $('#selectWidget').removeAttr('disabled');
                $('#selectModule').removeAttr('disabled');
                load_config();
            }
        });
    }

    function load_config()
    {
        if ($('#selectWidget').html() == '' || $("#selectWidget :selected").data('hasconfig') == 0) {
            $('#trConfig').html('');
        }
        if ($("#selectWidget :selected").data('hasconfig') == 1) {
            $('#selectWidget').attr('disabled', 'disabled');
            $('#selectModule').attr('disabled', 'disabled');
            $.ajax({
                type: 'post',
                url: "{{ route('cms.admin.ajaxLoadConfigWidget') }}",
                data: {
                    _token: _token,
                    module: $('#selectModule').val(),
                    widget: $('#selectWidget').val()
                },
                dataType: 'JSON',
                success: function(html) {
                    $('#trConfig').html(html);
                    $('#selectWidget').removeAttr('disabled');
                    $('#selectModule').removeAttr('disabled');
                }
            });
        }
    }
</script>
@endsection
