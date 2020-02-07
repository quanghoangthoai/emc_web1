@extends('Admin::layouts.default')
@section('page_title', 'Sửa quảng cáo "' . $banner['title'] . '"')

@section('page_content')
<form action="{{ route('mod_banner.admin.posteditbanner', $banner['id']) }}" method="post">
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
                    <input type="text" class="form-control w300" name="title" value="{{ old('title', $banner['title']) }}">
                </td>
            </tr>
            <tr>
                <td><strong>Thuộc khối</strong> <sup class="text-danger">(*)</sup></td>
                <td>
                    <select name="block_id" class="form-control select2 w300">
                        @foreach (mod_banner_get_list_block() as $block)
                        <option value="{{ $block['id'] }}" {{ old('block_id', $banner['block_id']) == $block['id'] ? 'selected' : '' }}>{{ $block['title'] }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Chọn file ảnh</strong> <sup class="text-danger">(*)</sup></td>
                <td>
                    <div class="input-group areaBrowserFile">
                        <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="file_src-image" class="form-control" name="file_src" value="{{ old('file_src', $banner['file_src']) }}">
                        <div class="input-group-prepend mr-0">
                            <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                            <button class="btn btn-dark btn-sm btn-choose-file" data-id="file_src-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><strong>Chú thích cho ảnh</strong></td>
                <td>
                    <input type="text" class="form-control w300" name="file_alt" value="{{ old('file_alt', $banner['file_alt']) }}">
                </td>
            </tr>
            <tr>
                <td><strong>Liên kết khi click vào ảnh</strong></td>
                <td>
                    <input type="text" class="form-control w300" name="link" value="{{ old('link', $banner['link']) }}">
                </td>
            </tr>
            <tr>
                <td><strong>Cách mở liên kết</strong></td>
                <td>
                    <select name="target" class="form-control select2 w300">
                        <option value="_blank" {{ old('target', $banner['target']) == '_blank' ? 'selected' : '' }}>Cửa sổ mới (_blank)</option>
                        <option value="_top" {{ old('target', $banner['target']) == '_top' ? 'selected' : '' }}>Cửa sổ trên cùng (_top)</option>
                        <option value="_self" {{ old('target', $banner['target']) == '_self' ? 'selected' : '' }}>Tại trang (_self)</option>
                        <option value="_parent" {{ old('target', $banner['target']) == '_parent' ? 'selected' : '' }}>Cửa sổ cha (_parent)</option>
                    </select>
                </td>
            </tr>
            {{-- <tr>
                <td><strong>Bắt đầu</strong></td>
                <td>
                    <input type="text" class="form-control w200 input-inline datepicker" placeholder="Chọn ngày" name="begin_date" value="{{ old('begin_date', date('d/m/Y', strtotime($banner['begin_time']))) }}">
            <select name="begin_hour" class="form-control input-inline" style="width:75px">
                @for ($i = 0; $i <= 23; $i++) <option value="{{ $i }}" {{ old('begin_hour', intval(date('H', strtotime($banner['begin_time'])))) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
            </select>
            <select name="begin_minute" class="form-control input-inline" style="width:75px">
                @for ($i = 0; $i <= 59; $i++) <option value="{{ $i }}" {{ old('begin_minute', intval(date('i', strtotime($banner['begin_time'])))) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
            </select>
            <a href="javascript:;" onclick="resetInput(this);return false;"><i class="fa fa-closefa fa-times-circle"></i></a>

            <span class="help-block help-block-bottom">Hệ thống tự lấy thời gian bắt đầu ngay lúc thêm quảng cáo nếu không chọn ngày ở đây</span>
            </td>
            </tr>
            <tr>
                <td><strong>Kết thúc</strong></td>
                <td>
                    <input type="text" class="form-control w200 input-inline datepicker" placeholder="Chọn ngày" name="expired_date" value="{{ old('expired_date', $banner['expired_time'] ? date('d/m/Y', strtotime($banner['expired_time'])) : '') }}">
                    <select name="expired_hour" class="form-control input-inline" style="width:75px">
                        @for ($i = 0; $i <= 23; $i++) <option value="{{ $i }}" {{ old('expired_hour', $banner['expired_time'] ? date('H', strtotime($banner['expired_time'])) : 23) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    <select name="expired_minute" class="form-control input-inline" style="width:75px">
                        @for ($i = 0; $i <= 59; $i++) <option value="{{ $i }}" {{ old('expired_minute', $banner['expired_time'] ? date('i', strtotime($banner['expired_time'])) : 59) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    <a href="javascript:;" onclick="resetInput(this);return false;"><i class="fa fa-closefa fa-times-circle"></i></a>

                    <span class="help-block help-block-bottom">Quảng cáo sẽ luôn hiển thị nếu không chọn ngày ở đây</span>
                </td>
            </tr> --}}
            <tr>
                <td><strong>Mô tả</strong></td>
                <td>
                    <textarea name="description" rows="3" class="form-control">{{ old('description', $banner['description']) }}</textarea>
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
