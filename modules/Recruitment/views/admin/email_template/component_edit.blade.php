<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title"><i class="fas fa-comment-dots mr-1"></i> <strong>SỬA MẪU PHẢN HỒI #{{ $editemail['id'] }}</strong></h6>
    </div>
    <div class="card-body">
        <form action="{{route('mod_recruitment.admin.post_edit_email_template', $editemail['id'])}}" method="post">
            @csrf
            <div class="form-group">
                <label class="col-form-label"><strong>Tên mẫu</strong> <sup class="text-danger">(∗)</sup></label>
                <input type="text" class="form-control" value="{{old('name', $editemail['name'])}}" name="name">
            </div>
            <div class="form-group">
                <label class="col-form-label"><strong>Nội dung phản hồi</strong> <sup class="text-danger">(∗)</sup></label>
                <textarea id="content" name="content">{{ $editemail['content'] }}</textarea>
            </div>
            <hr>
            <div class="text-right">
                <a href="{{ route('mod_recruitment.admin.list_email_template') }}" class="btn btn-dark btn-sm">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary btn-sm">Lưu lại</button>
            </div>
        </form>

    </div>
</div>
@section('custom_js')
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 300,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })
    });
</script>
@endsection
