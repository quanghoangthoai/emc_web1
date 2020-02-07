@extends('Admin::layouts.default')
@section('custom_css')
<style>
    .img-request {
        width: 100%;
        height: 200px;
    }

    .img-responsive {
        width: 100%;
    }

    .border-bottom {
        border-bottom-width: thin;
        margin-left: 20px;
        margin-right: 20px;
    }

    .thumbnail {
        position: relative;

    }

    .thumbnail:hover>.caption {
        opacity: 1;
    }

    .caption {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        opacity: 0;
        transition: 0.4s;
    }

    .tableShoppingCart tbody {
        display: block;
        max-height: 200px;
        overflow-y: scroll;
    }

    .tableShoppingCart thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>
@endsection
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fa fa-file-alt mr-2"></i> <span class="font-weight-semibold">Yêu cầu</span> - Thêm</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
    <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
            <a href="{{route('mod_request.admin.list_request')}}" class="btn btn-primary btn-sm">Danh sách yêu
                cầu</a>
        </div>
    </div>
</div>
@endsection
@section('page_content')
<form action="{{ route('mod_request.admin.post_edit_request', $iRequest['id']) }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-0 mr-0" style="border-bottom: 1px solid #ddd">
        {{-- start client info --}}
        <div class="col-lg-8 p-0" style="border-right: 1px solid #ddd; border-bottom: 1px solid #ddd">
            <div class="col-md-12 p-0" style="border-bottom: 1px solid #ddd">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title"><i class="fas fa-user"></i> Thông tin cá nhân</h5>

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><strong>Họ tên</strong> <sup class="text-danger">(*)</sup></label>
                        <div class="col-md-9">
                            <input placeholder="Nhập họ tên" readonly name="client_name" value="{{ old('client_name', $iRequest['client_name']) }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><strong>Số điện thoại</strong> <sup class="text-danger">(*)</sup></label>
                        <div class="col-md-9">
                            <input placeholder="Nhập số điện thoại" readonly name="client_phone" value="{{ old('client_phone',$iRequest['client_phone']) }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"><strong>Địa chỉ email</strong> <sup class="text-danger">(*)</sup></label>
                        <div class="col-md-9">
                            <input placeholder="Nhập địa chỉ mail" readonly name="client_email" value="{{ old('client_email', $iRequest['client_email']) }}" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-0" style="border-bottom: 1px solid #ddd">
                <div class="card-body">
                    <div class="form-group row mb-0">
                        <label class="col-md-3 col-form-label"><strong>Phương thức thanh toán</strong> </label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <div class="uniform-choice">
                                        <div class="uniform-choice">
                                            <input name="payment_method" disabled type="radio" class="form-check-input-styled" {{ old('payment_method', $iRequest['payment_method']) == 1 ? 'checked' : '' }} value="1">
                                        </div>
                                    </div>
                                    <span class="text-success">Chuyển khoản</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <div class="uniform-choice">
                                        <div class="uniform-choice">
                                            <input name="payment_method" disabled type="radio" class="form-check-input-styled" {{ old('payment_method', $iRequest['payment_method']) == 0 ? 'checked' : '' }} value="0">
                                        </div>
                                    </div>
                                    <span class="text-danger">Tiền mặt</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <div class="uniform-choice">
                                        <div class="uniform-choice">
                                            <input name="payment_method" disabled type="radio" class="form-check-input-styled" {{ old('payment_method', $iRequest['payment_method']) == 2 ? 'checked' : '' }} value="2">
                                        </div>
                                    </div>
                                    <span class="text-dark">Khác</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-0">

                {{ csrf_field() }}
                <div class="card-header header-elements-inline">
                    <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Thông tin đăng ký dịch vụ</h5>
                </div>
                <div class="card-body row ml-0 mr-0">
                    <div class="col-md-12 pd-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-body" style="width: 100%" id="shopping_cart">
                                            <div class="table-responsive">
                                                <table class="table tableShoppingCart" style="border: 1px solid #ddd">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="text-center">Sản phẩm</th>
                                                            <th class="text-center">Danh mục</th>
                                                            <th class="text-center">Đơn giá</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($shoppingCart)
                                                        @foreach ($shoppingCart as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $item['name'] }}</td>
                                                            <td class="text-center">{{ $item->category['name'] }}</td>
                                                            <td class="text-center">
                                                                @if ($item['enable_sale'])
                                                                <strong>{{ number_format($item['sale_price']) }}</strong>đ{{ $item['unit_type'] ? '/' . $item['unit_type'] : '' }}
                                                                <br>
                                                                <del><small>{{ number_format($item['price']) }}đ</small></del>
                                                                @else
                                                                <strong>{{ number_format($item['price']) }}</strong>đ{{ $item['unit_type'] ? '/' . $item['unit_type'] : '' }}
                                                                @endif
                                                            </td>


                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <td colspan="5" align="center">
                                                            Giỏ sản phẩm rỗng
                                                        </td>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">
                        <div id="bill_cart" style="border:1px solid #ddd;border-top:0;">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-5 col-form-label"><strong>Tạm tính(Chưa VAT):</strong></label>
                                    <div class="col-lg-7">
                                        <input readonly value="{{ $iRequest['total'] }}" name="total" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-form-label"><strong>Giảm giá:</strong></label>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <input type="text" readonly value="{{ $iRequest['sale_percent'] }}" readonly class="form-control" aria-label="">
                                            <div class="input-group-append ml-0">
                                                <span class="input-group-text ml-0">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-form-label"><strong>Thuế(VAT):</strong></label>
                                    <div class="col-lg-5">
                                        @if(isset($iRequest))
                                        <div class="input-group">
                                            <input type="number" min="0" max="100" readonly name="vat_percent" oninput="this.value = Math.abs(this.value)" id="input-vat-percent" value="{{ $iRequest['vat_percent'] }}" class="form-control" aria-label="">
                                            <div class="input-group-append ml-0">
                                                <span class="input-group-text ml-0">%</span>
                                            </div>
                                        </div>
                                        @else
                                        <div class="input-group">
                                            <input type="number" min="0" max="100" name="vat_percent" oninput="this.value = Math.abs(this.value)" id="input-vat-percent" value="{{ $vat_percent }}" class="form-control" aria-label="">
                                            <div class="input-group-append ml-0">
                                                <span class="input-group-text ml-0">%</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-5 col-form-label"><strong>Thành tiền:</strong></label>
                                    <div class="col-lg-7">
                                        <div class="percentInput">
                                            <input readonly name="payment" value="{{ $iRequest['payment'] }}" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- end client info --}}

        {{-- start status --}}
        <div class="col-lg-4 p-0" style="border-bottom: 1px solid #ddd">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><i class="fas fa-download"></i> Trạng thái</h5>
                {!! mod_request_get_status($iRequest['status']) !!}
            </div>

            <div class="card-body">
                <div class="form-group">
                    <a style="width:100%" href="javascript:;" data-toggle="modal" data-target="#modalHistory" class="btn btn-light legitRipple"><i class="fa fa-history mr-1"></i> Lịch sử phản
                        hồi</a>
                </div>
                <div class="form-group">
                    <label class="form-label"><strong>Trạng thái thanh toán</strong> <sup class="text-danger">(∗)</sup></label>
                    <select disabled name="status" class="form-control">
                        <option selected>
                            {{ mod_request_get_status_name($iRequest['status']) }}</option>
                    </select>
                </div>
                @include('Request::admin.component.fetch-image', ['actionType' => 'edit'])
                <div class="form-group">
                    <label class="form-label"><strong>Ghi chú</strong></label>
                    <div>
                        <textarea placeholder="Nhập nội dung ghi chú" readonly style="height: 200px" name="note" type="text" class="form-control">{{ old('note', $iRequest['note']) }}</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('mod_request.admin.list_request') }}" class="btn btn-info btn-sm">Quay lại danh sách</a>
                </div>
            </div>
        </div>
        {{-- end status --}}
        <hr>
    </div>
</form>
@include('Request::admin.component.log-modal')
@endsection
@section('custom_js')

@endsection