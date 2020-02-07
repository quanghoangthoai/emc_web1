<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title"><i class="fas fa-comment-dots mr-1"></i> <strong>THÊM MẪU PHẢN HỒI</strong></h6>
    </div>
    <div class="card-body">
        <form action="{{ route('mod_recruitment.admin.post_add_email_template') }}" method="post">
            @csrf
            <div class="form-group">
                <label class="col-form-label"><strong>Tên mẫu</strong> <sup class="text-danger">(∗)</sup></label>
                <input type="text" placeholder="Nhập tên mẫu" class="form-control" name="name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label"><strong>Nội dung phản hồi</strong> <sup class="text-danger">(∗)</sup></label>
                <textarea id="content" name="content">{{ old('content') }}</textarea>
            </div>
            <hr>
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">Thêm mẫu</button>
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
