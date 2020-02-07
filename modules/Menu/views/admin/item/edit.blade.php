@extends('Admin::layouts.default')
@section('page_title', 'Sửa mục: "' . $item['title'] . '"')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold"> Menu </span> - Sửa</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <form action="{{ route('mod_menu.admin.post_edit_item', $item['id']) }}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <td><strong>Thuộc mục</strong></td>
                            <td>
                                <select name="parent_id" class="form-control w300">
                                    <option value="0">-- Là mục chính --</option>
                                    @php
                                    $listItem = mod_menu_get_tree_menu($item['menu_id']);
                                    @endphp
                                    @if (count($listItem) > 0)
                                    @foreach ($listItem as $iitem)
                                    <option value="{{ $iitem['id'] }}" {{ $iitem['id'] == $item['parent_id'] ? 'selected' : '' }}>{{ $iitem['title'] }}</option>
                                    @if (count($iitem['submenu']) > 0)
                                    @foreach ($iitem['submenu'] as $submenu)
                                    <option value="{{ $submenu['id'] }}" {{ $submenu['id'] == $item['parent_id'] ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;{{ $submenu['title'] }}</option>
                                    @endforeach
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Liên kết đến module</strong></td>
                            <td>
                                <select id="selectModule" onchange="load_menu_item(this);return false;" name="module" class="form-control w200 input-inline">
                                    <option value="">-- Chọn module --</option>
                                    @foreach (get_list_module_has_menu() as $module)
                                    <option value="{{ $module['title']}}">{{ $module['title'] }}</option>
                                    @endforeach
                                </select>
                                <select name="item" id="selectItem" class="form-control w300 input-inline" onchange="insert_item_input();return false;">
                                    <option value="">Các mục thuộc module</option>
                                    @if (isset($listMItem))
                                    @foreach ($listMItem as $mItem)
                                    <option data-link="{{ $mItem['link'] }}" data-title="{{ $mItem['title'] }}" {{ $mItem['link'] == $item['link'] ? 'selected' : '' }}>{{ $mItem['title'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tên mục</strong> <sup class="required text-danger">(*)</sup></td>
                            <td>
                                <input id="txtTitle" name="title" value="{{ old('title', $item['title']) }}" type="text" class="form-control" placeholder="Nhập tên mục">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Đường dẫn liên kết</strong> <sup class="required text-danger">(*)</sup></td>
                            <td>
                                <input id="txtLink" name="link" value="{{ old('link', $item['link']) }}" type="text" class="form-control" placeholder="Nhập đường dẫn liên kết">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Mở trang liên kết</strong></td>
                            <td>
                                <select name="target" class="form-control w200">
                                    <option value="_blank" {{ old('target', $item['target']) == '_blank' ? 'selected' : '' }}>Cửa sổ mới</option>
                                    <option value="_top" {{ old('target', $item['target']) == '_top' ? 'selected' : '' }}>Cửa sổ trên cùng</option>
                                    <option value="_selft" {{ old('target', $item['target']) == '_selft' ? 'selected' : '' }}>Tại trang</option>
                                    <option value="_parent" {{ old('target', $item['target']) == '_parent' ? 'selected' : '' }}>Cửa sổ cha</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tiêu đề dài</strong></td>
                            <td>
                                <div class="form-group row">
                                    <div class="col">
                                        <textarea placeholder="Nhập tiêu đề dài" name="long_title" class="form-control" rows="5">{{ old('long_title', $item['long_title']) }}</textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Mô tả ngắn</strong></td>
                            <td>
                                <div class="form-group row">
                                    <div class="col">
                                        <textarea placeholder="Nhập mô tả ngắn" name="content" class="form-control" rows="5">{{ old('content', $item['content']) }}</textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-info">Lưu thay đổi</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('custom_js')
<script>
    $(document).ready(function(){
        if ($('#selectModule').val()) {
            $('#txtLink').attr('readonly', 'readonly');
        }
    });
    function load_menu_item(el)
    {
        $('#selectItem').attr('readonly', 'readonly');
        $.ajax({
            type: 'post',   
            url: "{{ route('mod_menu.admin.ajaxloadlistitem') }}",
            data: {
                _token: _token,
                module: $(el).val()
            },
            dataType: 'JSON',
            success: function(data) {
                var html = '<option value="">Các mục thuộc module</option>';
                if (data.length !== undefined && data.length > 0) {
                    data.forEach(function(item){
                        html += '<option data-link="'+ item.link +'" data-title="'+ item.title +'">'+ item.title +'</option>';
                    });
                }
                if ($(el).val() == '') {
                    $('#txtLink').val('').removeAttr('readonly');
                    $('#txtTitle').val('');
                }
                $('#selectItem').html(html);
                $('#selectItem').removeAttr('readonly');
            }
        });
    }

    function insert_item_input()
    {
        $('#txtLink').val($("#selectItem :selected").data('link')).attr('readonly', 'readonly');
        $('#txtTitle').val($("#selectItem :selected").data('title'));
    }
</script>
@endsection