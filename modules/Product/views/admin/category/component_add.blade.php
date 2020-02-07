<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">THÊM DANH MỤC</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_product.admin.post_add_category') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label><strong>Thuộc danh mục</strong></label>
                <select name="parent_id" class="form-control">
                    <option value="0">-- Là danh mục chính --</option>
                    @if (isset($listCategory) && count($listCategory))
                    @foreach ($listCategory as $cat)
                    <option value="{{ $cat['id'] }}" {{ old('parent_id') == $cat['id'] ? 'selected' : '' }}>{{ $cat['prefix'] }} {{ $cat['name'] }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label><strong>Tên danh mục</strong> <sup class="text-danger">(∗)</sup></label>
                <input name="name" type="text" class="form-control" placeholder="Nhập tên danh mục" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label><strong>Hình ảnh</strong> <sup class="text-danger">(∗)</sup></label>
                <div class="input-group areaBrowserFile">
                    <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="cat-image" class="form-control" name="image" value="{{ old('image') }}">
                    <div class="input-group-prepend mr-0">
                        <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                        <button class="btn btn-dark btn-sm btn-choose-file" data-id="cat-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><strong>Mô tả</strong></label>
                <textarea name="description" class="form-control" placeholder="Nhập mô tả" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-3"><strong>Trạng thái</strong></label>
                <div class="col-lg-9">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <div class="uniform-choice">
                                <div class="uniform-choice">
                                    <input name="status" type="radio" class="form-check-input-styled" {{ old('status', 1) == 1 ? 'checked' : '' }} value="1">
                                </div>
                            </div>
                            <span class="text-success">Hoạt động</span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <div class="uniform-choice">
                                <div class="uniform-choice">
                                    <input name="status" type="radio" class="form-check-input-styled" {{ old('status', 1) == 0 ? 'checked' : '' }} value="0">
                                </div>
                            </div>
                            <span class="text-danger">Tạm ngưng</span>
                        </label>
                    </div>
                </div>
            </div>

            <hr>
            <div class="float-right">
                <button type="submit" class="btn btn-primary btn-sm">Thêm danh mục</button>
            </div>
        </form>
    </div>
</div>
