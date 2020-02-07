<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">SỬA MẪU #{{ $ReplyTemplate_edit['id'] }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_ticket.admin.post_edit_replytemplate', $ReplyTemplate_edit['id']) }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label><strong>Tên mẫu</strong> <sup class="text-danger">(∗)</sup></label>
                <input name="name" id="txtTitle" type="text" class="form-control" placeholder="Nhập tên mẫu phản hồi" value="{{ old('name', $ReplyTemplate_edit['name']) }}">
            </div>
            <div class="form-group">
                <label><strong>Nội dung phản hồi</strong> <sup class="text-danger">(∗)</sup></label>
                <textarea name="content" id="content" class="form-control" rows="5" placeholder="Nhập nội dung">{{ old('content',$ReplyTemplate_edit['content']) }}</textarea>
            </div>
            <hr>
            <div class="float-right">
                <a href="{{ route('mod_ticket.admin.list_replytemplate') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary btn-sm">Lưu lại</button>
            </div>
        </form>
    </div>
</div>