<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">THÊM HẠNG MỤC</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_ticket.admin.post_add_category') }}" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label><strong>Tên hạng mục</strong> <sup class="text-danger">(∗)</sup></label>
                <input name="name" id="txtTitle" type="text" class="form-control" placeholder="Nhập tên hạng mục" value="{{ old('name') }}">
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
                <button type="submit" class="btn btn-primary btn-sm">Thêm hạng mục</button>
            </div>
        </form>
    </div>
</div>