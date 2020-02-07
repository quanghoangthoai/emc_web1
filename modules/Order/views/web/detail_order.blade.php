@extends('Client::layouts.default')

@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="detail-ticket">
                <h3 class="title">Chi tiết đơn hàng</h3>
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="w-25">Mã đơn hàng:</td>
                                <td>{{ $order['order_id'] }}</td>
                            </tr>
                            <tr>
                                <td class="w-25">Trạng thái:</td>
                                <td>{!! mod_order_get_html_status_web($order['status']) !!}</td>
                            </tr>
                            <tr>
                                <td class="w-25">Ngày khởi tạo:</td>
                                <td>{{ date('d/m/Y', strtotime($order['created_at'])) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table id="" class="table " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">STT</th>
                                    <th class="th-sm">Danh mục</th>
                                    <th class="th-sm">Tên sản phẩm</th>
                                    <th class="th-sm">Nội dung</th>
                                    <th class="th-sm" style="width: 150px;">Giá tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (mod_order_get_name_product($order['request_id']) as $key => $iPro)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><a href="#" target="_blank">{{ $iPro->category->name }}</a></td>
                                    <td><a href="#" target="_blank">{{ $iPro['name'] }}</a></td>
                                    <td>{!! $iPro['content'] !!}</td>
                                    <td>{{ number_format($iPro['price']) }} {{ $iPro['unit_type'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="w-75 text-right">Giá chưa thuế:</td>
                                <td class="text-right"><b>{{ number_format($request['total']) }} VNĐ</b></td>
                            </tr>
                            <tr>
                                <td class="w-75 text-right">Giảm giá:</td>
                                <td class="text-right"><b>{{ $request['sale_percent'] }} %</b></td>
                            </tr>
                            <tr>
                                <td class="w-75 text-right">Thuế (VAT):</td>
                                <td class="text-right"><b>{{ $request['vat_percent'] }} %</b></td>
                            </tr>
                            <tr>
                                <td class="w-75 text-right">Tổng giá trị:</td>
                                <td class="text-right"><b>{{ number_format($request['payment']) }} VNĐ</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection