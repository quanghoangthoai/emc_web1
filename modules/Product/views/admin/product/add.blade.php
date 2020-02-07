@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-cube mr-2"></i> <span class="font-weight-semibold">Sản phẩm</span> - Thêm</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_product.admin.list_product')}}" class="btn btn-primary btn-sm">Danh sách sản phẩm</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_product.admin.post_add_product') }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0">
        <div class="col-md-8 p-0" style="border-right: 1px solid #ddd">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Tên sản phẩm</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <input placeholder="Nhập tên sản phẩm" type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Giá niêm yết</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="price" value="{{ old('price', 0) }}" min="0" step="1000">
                            <span class="input-group-append ml-0"><span class="input-group-text">đ / </span></span>
                            <span class="input-group-append ml-0"><input placeholder="đơn vị tính" type="text" class="form-control" name="unit_type" value="{{ old('unit_type') }}"></span>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Hiển thị giá sản phẩm</strong></label>
                    <div class="col-lg-9">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="display_price" type="radio" class="form-check-input-styled" {{ old('display_price', 1) == 1 ? 'checked' : '' }} value="1">
                                    </div>
                                </div>
                                <span class="text-success">Hiển thị</span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <div class="uniform-choice">
                                    <div class="uniform-choice">
                                        <input name="display_price" type="radio" class="form-check-input-styled" {{ old('display_price', 1) == 0 ? 'checked' : '' }} value="0">
                                    </div>
                                </div>
                                <span class="text-danger">Ẩn</span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <a data-toggle="collapse" class="text-default collapsed" href="#collapsible-saleoff" aria-expanded="true">
                    <h6 class="text-warning"><strong>THÔNG TIN KHUYẾN MÃI</strong></h6>
                </a>
                <div id="collapsible-saleoff" class="collapse show">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-9">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input name="enable_sale" type="checkbox" class="form-check-input-styled" value="1" {{ old('enable_sale') ? 'checked' : '' }}>
                                    <strong>Kích hoạt khuyến mãi</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><strong>Thời gian khuyến mãi</strong></label>
                        <div class="col-lg-9">
                            <input autocomplete="off" name="sale_time" type="text" class="form-control daterange-basic" value="{{ old('sale_time') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><strong>Giá khuyến mãi</strong></label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input type="number" class="form-control" name="sale_price" value="{{ old('sale_price', 0) }}" min="0" step="1000">
                                <span class="input-group-append ml-0"><span class="input-group-text">đ</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Hình ảnh</strong></label>
                    <div class="col-lg-9">
                        <div class="input-group areaBrowserFile">
                            <input placeholder="Chưa chọn hình ảnh" readonly type="text" id="product-image" class="form-control" name="image" value="{{ old('image') }}">
                            <div class="input-group-prepend mr-0">
                                <button class="btn btn-light btn-sm btn-remove-file text-danger" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-dark btn-sm btn-choose-file" data-id="product-image" type="button"><i class="fa fa-image mr-1"></i> Chọn ảnh</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Mô tả ngắn</strong></label>
                    <div class="col-lg-9">
                        <textarea placeholder="Nhập mô tả ngắn" name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-12 col-form-label"><strong>Nội dung chi tiết</strong></label>
                    <div class="col-lg-12">
                        <textarea id="content" name="content" rows="3" class="form-control">{{ old('content') }}</textarea>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4 p-0">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-12 col-form-label"><strong>Danh mục</strong> <sup class="text-danger">(*)</sup></label>
                    <div class="col-lg-12">
                        <select name="category_id" class="form-control">
                            <option value="">-- Chưa chọn --</option>
                            @if (isset($listCategory) && count($listCategory))
                            @foreach ($listCategory as $cat)
                            <option value="{{ $cat['id'] }}" {{ old('category_id') == $cat['id'] ? 'selected' : '' }}>{{ $cat['prefix'] }} {{ $cat['name'] }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"><strong>Nổi bật</strong> </label>
                    <div class="col-md-9">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input name="featured" type="checkbox" class="form-check-input-styled" value="1" {{ old('featured') ? 'checked' : '' }}>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"><strong>Trạng thái</strong> </label>
                    <div class="col-md-9">
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
                    <a href="{{ route('mod_product.admin.list_product') }}" class="btn btn-dark">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('custom_js')
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        CKEDITOR.replace('content',{
            language: 'vi',
            height: 400,
            filebrowserBrowseUrl: '/file-manager/ckeditor'
        })
    });
</script>
<script src="{{ asset('assets/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
<script>
    $('.daterange-basic').daterangepicker({
        timePicker: true,
        locale: {
            format: 'DD/MM/YYYY HH:mm'
        }
    }).val('');
</script>
@endsection
