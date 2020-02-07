<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">THÊM MẪU PHẢN HỒI</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_ticket.admin.post_add_replytemplate') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label><strong>Tên mẫu</strong> <sup class="text-danger">(∗)</sup></label>
                <input name="name" id="txtTitle" type="text" class="form-control" placeholder="Nhập tên mẫu phản hồi" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label><strong>Nội dung phản hồi</strong> <sup class="text-danger">(∗)</sup></label>
                <textarea name="content" id="content" class="form-control" rows="5" placeholder="Nhập nội dung">{{ old('content') }}</textarea>
            </div>
            <hr>
            <div class="float-right">
                <button type="submit" class="btn btn-primary btn-sm">Thêm mẫu</button>
            </div>
        </form>
    </div>
</div>