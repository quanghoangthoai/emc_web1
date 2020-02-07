@extends('Admin::layouts.default')
@section('page_title', 'Sửa khối "' . $block['title'] . '"')

@section('page_content')
<form action="{{ route('mod_banner.admin.posteditblock', $block['id']) }}" method="post">
    {{ csrf_field() }}
    <table class="table table-bordered table-td-middle">
        <colgroup>
            <col class="w200">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <td><strong>Tiêu đề</strong> <sup class="text-danger">(*)</sup></td>
                <td>
                    <input type="text" class="form-control w300" name="title" value="{{ old('title', $block['title']) }}">
                </td>
            </tr>
            <tr>
                <td><strong>Kích thước quảng cáo</strong> <sup class="text-danger">(*)</sup></td>
                <td>
                    <input type="text" class="form-control input-inline" name="width" value="{{ old('width', $block['width']) }}" placeholder="Rộng" style="width:120px">
                    x
                    <input type="text" class="form-control input-inline" name="height" value="{{ old('height', $block['height']) }}" placeholder="Cao" style="width:120px">
                </td>
            </tr>
            <tr>
                <td><strong>Kiểu hiển thị</strong> <sup class="text-danger">(*)</sup></td>
                <td>
                    <select name="form" class="form-control w200">
                        <option value="1" {{ old('form', $block['form']) == 1 ? 'selected' : '' }}>Theo thứ tự</option>
                        <option value="2" {{ old('form', $block['form']) == 2 ? 'selected' : '' }}>Ngẫu nhiên</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Loại quảng cáo</strong> <sup class="text-danger">(*)</sup></td>
                <td>
                    <select name="type" class="form-control w200">
                        <option value="1" {{ old('type', $block['type']) == 1 ? 'selected' : '' }}>Hình ảnh</option>
                        <option value="2" {{ old('type', $block['type']) == 2 ? 'selected' : '' }}>Textlink</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Mô tả</strong></td>
                <td>
                    <textarea name="description" rows="3" class="form-control">{{ old('description', $block['description']) }}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-info">Lưu thay đổi</button>
        </div>
    </div>
</form>
@endsection
