@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="order">
                <h3 class="title">Đơn hàng</h3>
                <div class="text-right mb-3">
                    <button type="button" class="btn btn-success" id="" onclick="location.href='{{ route('client.products') }}'"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
                </div>
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Mã đơn hàng</th>
                            <th class="th-sm" style="width: 25%;">Tên sản phẩm</th>
                            <th class="th-sm">Thời gian</th>
                            <th class="th-sm">Tổng tiền</th>
                            <th class="th-sm">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{ route('client.detail_order') }}">12418NS</a></td>
                            <td>
                                <ul>
                                    <li><a href="https://www.emcvn.vn/vn" target="_blank">Gói dịch vụ tư vấn pháp lý</a></li>
                                    <li><a href="https://www.emcvn.vn/vn" target="_blank">Dịch vụ kế toán</a></li>
                                </ul>
                            </td>
                            <td>18/10/2019</td>
                            <td>
                                <ul>
                                    <li>3.000.000đ</li>
                                    <li>5.000.000đ</li>
                                </ul>
                            </td>
                            <td><span class="text-primary">Đang xử lý</span></td>
                        </tr>
                        <td><a href="{{ route('client.detail_order') }}">12418NS</a></td>
                        <td><a href="https://www.emcvn.vn/vn" target="_blank">Gói dịch vụ tuyển dụng nhân sự</a></td>
                        <td>20/07/2018</td>
                        <td>4.870.800đ</td>
                        <td><span class="text-success">Hoàn thành</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
@endsection