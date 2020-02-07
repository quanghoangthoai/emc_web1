@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-ticket-alt mr-2"></i> <span class="font-weight-semibold">Yêu cầu hỗ trợ</span> - Tạo mới</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('page_content')
<div class="card-body">
    <form action="{{ route('mod_ticket.admin.post_create_ticket') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title"><strong>Email khách hàng</strong> <sup class="text-danger">(∗)</sup></label>
                    <div class="input-group">
                        <input type="text" placeholder="Nhập email khách hàng" id="email" name="email" class="form-control" value="{{ old('email') }}">
                        <div class="input-group-prepend mr-0">
                            <a href="javascript:;" class="btn btn-dark btn-sm" data-popup="tooltip" title="Kiểm tra" id="btn-load-product"><em class="fa fa-sync"></em></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="product_id"><strong>Dịch vụ</strong> <sup class="text-danger">(∗)</sup></label>
                    <div class="col-lg-12" style="padding: 0" id="load-product">
                        <select name="product_id" class="form-control" id="product_id">
                            <option value="">-- Chọn dịch vụ --</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category_id"><strong>Hạng mục</strong> <sup class="text-danger">(∗) </sup></label>
                    <div class="col-lg-12" id="option_category" style="padding: 0">
                        @if (isset($listCategory) && count($listCategory))
                        <select name="category_id" class="form-control" id="category_id">
                            <option value="">-- Chọn hạng mục --</option>
                            @foreach ($listCategory as $key => $cat)
                            <option value="{{ $cat['id'] }}" @if (old('category_id')==$cat['id']) {{ 'selected' }} @endif>{{ $cat['name'] }}
                            </option>
                            @endforeach
                        </select>
                        @else
                        <div class="alert alert-info" style="padding: 6px">Chưa có hạng mục nào</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group field">
                    <label for="title"><strong>Tiêu đề</strong> <sup class="text-danger">(∗)</sup></label>
                    <div class="col-lg-12" style="padding: 0">
                        <input type="text" placeholder="Nhập tiêu đề" id="title" name="title" class="form-control" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="form-group field">
                    <label for="content"><strong>Nội dung yêu cầu</strong> <sup class="text-danger">(∗)</sup></label>
                    <div class="col-lg-12" style="padding: 0">
                        <textarea name="content" id="content" rows="5" class="form-control" placeholder="Nhập nội dung">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="attachments"><strong>File đính kèm</strong> </label>
                    <b class="ml-2 mb-2" id="add-input-file" title="Thêm file"> <i class="fa fa-plus-circle"></i></b>
                    <div class="add-file">
                        <div class="col-lg-12" style="padding: 0">
                            <input type="file" style="height: auto" class="form-control" name="attachments[]" id="attachments">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-2" id="btnsend">Tạo yêu cầu</button>
        </div>
    </form>
</div>
@endsection

@section('custom_js')
{{-- js add input file --}}
<script>
    $(document).ready(function(){
                    $("#add-input-file").click(function(){
                        $(".add-file").append('<div class="col-lg-12" style="padding: 0"><input style="width: 90%;height: auto;float:left;" type="file" class="form-control mt-2 fileinput" name="attachments[]" id="attachments"><a class="btn btn-default mt-2" onclick="removeFile(this);" style="width: 10%;float:right;line-height: 30px;"><i class="fa fa-times-circle" aria-hidden="true" style="color:red"></i></a></div>');
                    });
                });
                function removeFile(el)
                {
                     $(el).parent().remove();
                }
</script>
<script>
    $(document).ready(function(){
        $("#btn-load-product").click(function(){
            $.ajax({
                type:'POST',
                url:"{{ route('mod_ticket.ajax.loadproductfromemail') }}",
                data: {
                    _token: _token,
                    email: $("#email").val()
                },
                dataType: 'JSON',
                success:function(res) {
                    if (res.status) {
                        app.showNotify(res.msg, 'success');
                        $("#product_id").html(res.data);
                    } else {
                        app.showNotify(res.msg, 'error');
                        $("#product_id").html(res.data);
                    }
                }
            });
        });
    });
</script>
@endsection