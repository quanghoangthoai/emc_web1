@extends('Client::layouts.default')

@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="order">
                <h3 class="title">Đơn hàng</h3>
                <div class="text-right mb-3">
                    <a href="#" class="btn btn-success" id=""><i class="fas fa-plus"></i> Thêm sản phẩm</a>
                </div>
                @if (isset($listOrder) && count($listOrder))
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">STT</th>
                            <th class="th-sm">Mã đơn hàng</th>
                            <th class="th-sm" style="width: 25%;">Tên sản phẩm</th>
                            <th class="th-sm">Giá tiền</th>
                            <th class="th-sm">Thời gian</th>
                            <th class="th-sm">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listOrder as $key => $iOrder)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td><a href="{{ route('client.detail_order',$iOrder['order_id']) }}">{{ $iOrder['order_id'] }}</a></td>
                            <td>
                                <ul>
                                    @foreach (mod_order_get_name_product($iOrder['request_id']) as $iPro)
                                    <li><a href="#" target="_blank">{{ $iPro['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach (mod_order_get_name_product($iOrder['request_id']) as $iPro)
                                    <li>{{ number_format($iPro['price']) }} {{ $iPro['unit_type'] }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($iOrder['updated_at'])) }}</td>
                            <td>{!! mod_order_get_html_status_web($iOrder['status']) !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    Chưa có đơn hàng nào
                </div>
                @endif
            </section>
        </div>
    </div>
</main>
@endsection