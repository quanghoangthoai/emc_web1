<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><strong>SỬA DANH MỤC</strong> </h5>
    </div>
    {{-- <hr> --}}

    <div class="card-body">
        <form action="{{ route('mod_library.admin.post_edit_category', $cat['id']) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset class="mb-3">
                <div class="form-group ">
                    <label class="col-form-label"><strong>Danh mục cha</strong> <sup class="text-danger">(*)</sup></label>
                    <select class="form-control" name="parent_id">
                        <option value="0" selected>Không</option>
                        @if ($listCat && count($listCat) > 0)
                        @foreach ($listCat as $k => $iCategory)
                        @if ($iCategory['id'] != $cat['id'])
                        <option value="{{ $iCategory['id'] }}" {{ $cat['parent_id'] == $iCategory['id'] ? 'selected': '' }}>{{ $iCategory['prefix'] }} {{ $iCategory['name'] }}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group ">
                    <label class="col-form-label"><strong>Tên danh mục</strong> <sup class="text-danger">(*)</sup></label>
                    <input placeholder="Nhập tên danh mục" id="txtTitle" value="{{ old('name', $cat['name']) }}" type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label class="col-form-label"><strong>Liên kết tĩnh</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="input-group">
                        <input placeholder="Nhập liên kết tĩnh" id="txtSlug" type="text" class="form-control" name="slug" value="{{ old('slug', $cat['slug']) }}">
                        <div class="input-group-prepend mr-0">
                            <a href="javascript:;" onclick="get_slug('#txtTitle', '#txtSlug');" class="btn btn-dark btn-sm"><em class="fa fa-sync"></em></a>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-form-label"><strong>Định dạng</strong> <sup class="text-danger">(*)</sup></label>
                    <select class="form-control" name="format_type">
                        <option value=''>Không</option>
                        @if (mod_library_get_list_format_type())
                        @foreach (mod_library_get_list_format_type() as $key => $value)
                        <option value="{{ $key }}" {{ old('format_type', $cat['format_type']) == $key ? 'selected' : ''}}>{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label><strong>Hình ảnh</strong></label>
                    <div class="input-group areaBrowserFile">
                        <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="cat-image" class="form-control" name="image" value="{{ old('image', $cat['image']) }}">
                        <div class="input-group-prepend mr-0">
                            <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                            <button class="btn btn-dark btn-sm btn-choose-file" data-id="cat-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-form-label"><strong>Mô tả</strong> </label>
                    <textarea placeholder="Nhập mô tả" rows="5" name="description" class="form-control">{{ old('description', $cat['description']) }}</textarea>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"><strong>Trạng thái</strong></label>
                    <div class="col-lg-9">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $cat['status']) == 1 ? 'checked' : '' }} value="1">
                                    </div>
                                </div>
                                <span class="text-success">Hoạt động</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="status" type="radio" class="form-check-input-styled" {{ old('status', $cat['status']) == 0 ? 'checked' : '' }} value="0">
                                    </div>
                                </div>
                                <span class="text-danger">Tạm ngưng</span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
            </fieldset>
            <div class="text-right">
                <a href="{{ route('mod_library.admin.get_list_category') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary btn-sm">Lưu lại</button>
            </div>
        </form>
    </div>
</div>