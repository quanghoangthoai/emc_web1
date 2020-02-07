<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">CẬP NHẬT PHÒNG BAN</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_user.admin.post_edit_department', $editdepartment['id']) }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Tên phòng ban <sup class="text-danger">(*)</sup></label>
                <input name="name" type="text" class="form-control" placeholder="Nhập tên phòng ban" value="{{ old('name', $editdepartment['name']) }}">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" class="form-control" placeholder="Nhập mô tả" rows="3">{{ old('description', $editdepartment['description']) }}</textarea>
            </div>
            <div class="float-right">
                <a href="{{ route('mod_user.admin.list_department') }}" class="btn btn-default">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary legitRipple">Lưu lại</button>
            </div>
        </form>
    </div>
</div>
