@extends('admin.layouts.default')
@section('page_title', 'Sửa widget #' . $widget['id'])

@section('page_content')
<form action="{{ route('admin.widget.postedit', $widget['id']) }}" method="post">
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
                            <option value="{{ $mod['key'] }}" {{ $widget['module'] == $mod['key'] ? 'selected' : '' }}>
                                {{ $mod['title'] }}</option>
                            @endforeach
                        </select>
                        <select id="selectWidget" name="name" class="form-control input-inline w300" onchange="load_config();return false;">
                            @foreach ($listWidget as $iWidget)
                            <option value="{{ $iWidget['value'] }}" data-hasconfig="{{ $iWidget['hasConfig'] }}" {{ $iWidget['value'] == $widget['name'] ? 'selected' : '' }}>{{ $iWidget['value'] }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="trConfig"></tr>
                <tr>
                    <td><strong>Tiêu đề</strong> <sup class="required">(*)</sup></td>
                    <td>
                        <input name="title" type="text" class="form-control w300" value="{{ old('title', $widget['title']) }}">
                    </td>
                </tr>
                <tr>
                    <td><strong>URL của tiêu đề</strong></td>
                    <td>
                        <input name="link" type="text" class="form-control" value="{{ old('link', $widget['link']) }}">
                    </td>
                </tr>
                <tr>
                    <td><strong>Template</strong> <sup class="required">(*)</sup></td>
                    <td>
                        <select name="template" class="form-control w200">
                            @foreach (get_list_template_widget() as $itpl)
                            <option value="{{ $itpl }}" {{ old('template', $widget['template']) == $itpl ? 'selected' : '' }}>{{ $itpl }}
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
                            <option value="{{ $position }}" {{ old('position', $widget['position']) == $position ? 'selected' : '' }}>
                                {{ $position }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Kích hoạt</strong></td>
                    <td>
                        <input name="active" value="1" type="checkbox" class="minimal" {{ $widget['active'] ? 'checked' : '' }}>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-info">Lưu thay đổi</button>
        </div>
    </div>
</form>
@endsection
@section('custom_js')
<script>
    $(document).ready(function(){
        @if (count($arrConfig) > 0)
            load_config({!! json_encode($widget["config"]) !!});
        @endif
    });
    function load_widget_module(el)
    {
        var module = $(el).val();
        $.ajax({
            type: 'post',
            url: "{{ route('admin.widget.ajaxLoadWidgetModule') }}",
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
                load_config();
            }
        });
    }

    function load_config(default_config = '')
    {
        if ($('#selectWidget').html() == '' || $("#selectWidget :selected").data('hasconfig') == 0) {
            $('#trConfig').html('');
        }
        if ($("#selectWidget :selected").data('hasconfig') == 1) {
            $.ajax({
                type: 'post',
                url: "{{ route('admin.widget.ajaxLoadConfigWidget') }}",
                data: {
                    _token: _token,
                    module: $('#selectModule').val(),
                    widget: $('#selectWidget').val(),
                    config: default_config
                },
                dataType: 'JSON',
                success: function(html) {
                    $('#trConfig').html(html);
                }
            });
        }
    }
</script>
@endsection
