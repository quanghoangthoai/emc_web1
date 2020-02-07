@extends('Client::layouts.default')

@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="add-ticket">
                <h3 class="title">Tạo yêu cầu hỗ trợ</h3>
                <div class="alert alert-info mb-4" role="alert">
                    Quý khách vui lòng cung cấp đầy đủ thông tin để bộ phận hỗ trợ EMC có thể liên hệ phối hợp xử lý yêu cầu cho Quý khách được thuận tiện. Cảm ơn Quý khách hợp tác.
                </div>
                <form action="{{ route('client.post_add_ticket') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Dịch vụ <span>*</span></label>
                        <div class="col-sm-10">
                            @if (isset($listProduct) && count($listProduct))
                            <select class="custom-select" id="product_id" name="product_id">
                                @foreach ($listProduct as $iPro)
                                <option value="{{ $iPro['id'] }}" {{ (old('product_id') == $iPro['id']) ? 'selected' : '' }}>{{ $iPro['name'] }}</option>
                                @endforeach
                            </select>
                            @else
                            <div class="alert alert-info">Bạn chưa sử dụng dịch vụ nào của chúng tôi</div>
                            @endif
                            <div style="color: red">
                                @if ($errors->first('product_id') != null)
                                {!! '<i class="fas fa-times-circle"></i> '.$errors->first('product_id') !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <small>Vui lòng chọn chính xác một trong những hạng mục cần được hỗ trợ sau đây: <span>*</span></small>
                            <div class="row mt-3 mb-3">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    @if (isset($listCategory) && count($listCategory))
                                    @foreach ($listCategory as $key => $iCa)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="option{{ $key+1 }}" name="category_id" value="{{ $iCa['id'] }}" class="custom-control-input" {{ (old('category_id') == $iCa['id']) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="option{{ $key+1 }}">{{ $iCa['name'] }}</label>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="alert alert-info">Không có hạng mục nào</div>
                                    @endif
                                    <div style="color: red">
                                        @if ($errors->first('category_id') != null)
                                        {!! '<i class="fas fa-times-circle"></i> '.$errors->first('category_id') !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Tiêu đề <span>*</span></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="title" name="title" placeholder="Nhập tiêu đề" value="{{ old('title') }}">
                            <div style="color: red">
                                @if ($errors->first('title') != null)
                                {!! '<i class="fas fa-times-circle"></i> '.$errors->first('title') !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nội dung <span>*</span></label>
                        <div class="col-sm-10">
                            <textarea name="content" id="summernote">{{ old('content') }}</textarea>
                            <div style="color: red">
                                @if ($errors->first('content') != null)
                                {!! '<i class="fas fa-times-circle"></i> '.$errors->first('content') !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Đính kèm <a href="javascript:;" class="ml-2 mb-2" id="add-input-file"> <i class="fas fa-plus-circle" title="Thêm file"></i></a></label>
                        <div class="col-sm-10">
                            <div class="add-file">
                                <input type="file" class="form-control-file" name="attachments[]" id="attachments">
                            </div>
                            <span class="help-block">Hỗ trợ định dạng: .jpg, .gif, .jpeg, .png, .zip, .7z, .tar, .gzip, .doc, .docx, .xls, .xlsx, .pdf</span>
                        </div>
                    </div>
                    <div class="mt-2 text-right">
                        <a style="padding:8px 10px !important;min-width: 112px;" href="{{ route('client.tickets') }}" class="btn btn-warning" id="">Hủy</a>
                        @if (isset($listProduct) && count($listProduct))
                        <button type=" button" class="btn btn-success" id="">Gửi yêu cầu</button>
                        @endif
                    </div>
                    @if (session('success'))
                    <div style="display: none" id="check-success">{!! session('success') !!}</div>
                    @endif
                </form>
            </section>
        </div>
    </div>
</main>
{{-- modal --}}
<button type="button" style="display: none" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="showModel">Open Modal</button>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center" style="color: #00a859">
                    <i class="fas fa-check-circle fa-4x pb-2"></i>
                    <p> <strong>Đã gửi yêu cầu hỗ trợ thành công. Chúng tôi sẽ trả lời bạn trong thời gian sớm nhất. Xin cảm ơn!</strong></p>
                </div>
            </div>
            <div class="text-center pb-3">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    $('#summernote').summernote({
        height: 200,
        placeholder: 'Nhập nội dung ...'
    });
</script>
<script>
    $(document).ready(function(){
        $("#add-input-file").click(function(){
            $(".add-file").append('<div><input style="width: 95%;float:left;" type="file" class="form-control-file mt-2 fileinput" name="attachments[]" id="attachments"><a href="javascript:;" class="btn btn-default mt-2" onclick="removeFile(this);" style="width: 5%;float:right;"><i class="fas fa-times-circle" aria-hidden="true" style="color:red" title="Xóa"></i></a></div>');
        });
    });
    function removeFile(el)
    {
        $(el).parent().remove();
    }
</script>
<script>
    $(document).ready(function(){
        if ($("#check-success").text() == "1") {
            $("#showModel").click();
        };
    });
</script>
@endsection