@extends('Admin::layouts.default')
@section('page_header')
<div class="page-header-content header-elements-md-inline">
    <div class="page-title d-flex">
        <h4><i class="fab fa-first-order mr-2"></i> <span class="font-weight-semibold">Đơn hàng</span> - Chi tiết #2</h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
</div>
@endsection
@section('custom_css')
<style>
    .content-wrapper {
        overflow: hidden;
    }
</style>
@endsection
@section('page_content')
<div class="row" style="margin: 0">
    <div style="width: 100%">
        <div class="row">
            <div class="col-md-7 pl-4 pt-2 pb-2" style="border-right: solid 1px #ddd">
                <p>
                    <strong>
                        <h6>THÔNG TIN ĐƠN HÀNG <div class="float-right mb-5" id="status_cus">{!! mod_order_get_html_status(mod_order_get_staus_by_request($request['id'])) !!}</div>
                        </h6>
                    </strong>
                </p>
                <h6 style="border-bottom: solid 1px #ddd;"><i class="fa fa-user mr-1" style="font-size: 1em;"></i><strong>Thông tin khách hàng</strong></h6>
                <table>
                    <tr>
                        <td style="padding-bottom: 15px"><strong>Họ và tên:</strong></td>
                        <td style="padding-left: 30px;padding-bottom: 15px">{{ $request['client_name'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px"><strong>Email:</strong></td>
                        <td style="padding-left: 30px;padding-bottom: 15px">{{ $request['client_email'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px"><strong>Số điện thoại:</strong> </td>
                        <td style="padding-left: 30px;padding-bottom: 15px">{{ $request['client_phone'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px"><strong>Yêu cầu tạo lúc:</strong></td>
                        <td style="padding-left: 30px;padding-bottom: 15px">{{ date('H:i:s d/m/Y', strtotime($request['created_at'])) }}</td>
                    </tr>
                </table>
                <h6 style="border-bottom: solid 1px #ddd;"><i class="fa fa-th-list mr-1" style="font-size: 1em;"></i><strong>Chi tiết đơn hàng</strong></h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width: 40%;">Danh mục</th>
                                <th class="text-center" style="width: 40%;">Gói sản phẩm</th>
                                <th class="text-center" style="width: 20%;">Số tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listProduct as $iPro)
                            <tr>
                                <td class="text-center">{{ $iPro->category['name'] }}</td>
                                <td class="text-center">{{ $iPro['name'] }}</td>
                                <td class="text-center">{{ number_format($iPro['price']) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h6 style="border-bottom: solid 1px #ddd;"><i class="fa fa-th mr-1" style="font-size: 1em;"></i><strong>Thông tin thanh toán</strong></h6>
                <table>
                    <tr>
                        <td style="padding-bottom: 15px">
                            <strong>Tổng tiền (chưa VAT):</strong>
                        </td>
                        <td style="padding-left: 30px;padding-bottom: 15px">
                            <strong>{{ number_format($request['total']) }}</strong>&ensp;VNĐ
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                            <strong>Giảm giá:</strong>
                        </td>
                        <td style="padding-left: 30px;padding-bottom: 15px">
                            <strong>{{ $request['sale_percent'].'%' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                            <strong>Thuế (VAT):</strong>
                        </td>
                        <td style="padding-left: 30px;padding-bottom: 15px">
                            <strong>{{ $request['vat_percent'].'%' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                            <strong>Tiền thực phải trả:</strong>
                        </td>
                        <td style="padding-left: 30px;padding-bottom: 15px">
                            <strong>{{ number_format($request['payment']) }}</strong>&ensp;VNĐ
                        </td>
                    </tr>
                </table>

                <h6 style="border-bottom: solid 1px #ddd;"><i class="fa fa-sticky-note mr-1" style="font-size: 1em;"></i><strong>Ghi chú của khách hàng</strong></h6>
                <blockquote class="blockquote blockquote-bordered py-2 pl-2 mb-0">
                    {!! ($request['note'] != '') ? $request['note'] : '<i>Không có</i>' !!}
                </blockquote>
            </div>
            <div class="col-md-5 pl-4 pt-2 pr-4">
                <p>
                    <strong>
                        <h6></i> DÀNH CHO NHÂN VIÊN</h6>
                    </strong>
                </p>
                <h6 style="border-bottom: solid 1px #ddd;"><i class="fa fa-hand-paper mr-1" style="font-size: 1em;"></i><strong>Chọn thao tác</strong></h6>
                <div class="text-center pb-3">
                    @if (mod_order_get_staus_by_request($request['id']) == 4)
                    <a href="{{ route('mod_order.admin.open_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-dark mb-1" style="width: 100%">Mở lại đơn hàng</a>
                    @elseif(mod_order_get_staus_by_request($request['id']) == 1)
                    <a href="{{ route('mod_order.admin.process_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-primary mb-1" style="width: 100%">Xử lý</a>
                    <a href="{{ route('mod_order.admin.finish_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-warning mb-1" style="width: 100%">Hoàn thành</a>
                    <a href="{{ route('mod_order.admin.cancel_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-danger mb-1" style="width: 100%">Hủy bỏ</a>
                    @else
                    @if (mod_order_get_staus_by_request($request['id']) != 2)
                    <a href="{{ route('mod_order.admin.process_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-primary mb-1" style="width: 100%">Xử lý</a>
                    <a href="{{ route('mod_order.admin.cancel_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-danger mb-1" style="width: 100%">Hủy bỏ</a>
                    @elseif(mod_order_get_staus_by_request($request['id']) != 3)
                    <a href="{{ route('mod_order.admin.finish_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-warning mb-1" style="width: 100%">Hoàn thành</a>
                    <a href="{{ route('mod_order.admin.cancel_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-danger mb-1" style="width: 100%">Hủy bỏ</a>
                    @else
                    <a href="{{ route('mod_order.admin.cancel_order',mod_order_get_orderid_by_request($request['id'])) }}" class="btn btn-danger mb-1" style="width: 100%">Hủy bỏ</a>
                    @endif
                    @endif
                </div>

                <h6 style="border-bottom: solid 1px #ddd;"><i class="fa fa-history mr-1" style="font-size: 1em;"></i><strong>Hoạt động</strong></h6>
                <div class="timeline-left">
                    <div class="timeline-container" style="max-height: 400px;padding-right:15px;overflow-y: auto;">
                        @if (isset($listActivityLog) && count($listActivityLog))
                        @foreach ($listActivityLog as $iActi)
                        <div class="timeline-row">
                            <div class="timeline-icon">
                                <a href="javascript:;"><img src="{{ asset('default.jpg') }}" alt="Administrator"></a>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <p class="m-0"><strong>{{ user_display_name($iActi['staff_id']) }}</strong> {{ $iActi['action'] }}</p>
                                    <p class="text-right m-0 p-0"><em data-popup="tooltip" title="{{ date('H:i:s d/m/Y', strtotime($iActi['created_at'])) }}">{{ cms_time_elapsed_string($iActi['created_at']) }}</em></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="card">
                            <div class="card-body">
                                <p class="m-0"><strong>Chưa có lịch sử</strong></p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
