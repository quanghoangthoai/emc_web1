@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="service-use">
                <h3 class="title">Sản phẩm đã mua</h3>
                <div class="text-right mb-3">
                    <button type="button" class="btn btn-success" id="" onclick="location.href='{{ route('client.products') }}'"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
                </div>
                <table id="dtBasicExample" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Mã đơn hàng</th>
                            <th class="th-sm" style="width:30%;">Tên sản phẩm</th>
                            <th class="th-sm">Ngày ký</th>
                            <!-- <th class="th-sm">Ngày hết hạn</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12418NS</td>
                            <td>
                                <ul>
                                    <li><a href="https://www.emcvn.vn/vn" target="_blank">Gói dịch vụ tư vấn pháp lý</a></li>
                                    <li><a href="https://www.emcvn.vn/vn" target="_blank">Dịch vụ kế toán</a></li>
                                </ul>
                            </td>
                            <td>07/03/2019</td>
                            <!-- <td>07/03/2020</td> -->
                        </tr>
                        <tr>
                            <td>12418NS</td>
                            <td><a href="#">Gói dịch vụ tuyển dụng nhân sự</a></td>
                            <td>12/07/2018</td>
                            <!-- <td>12/07/2020</td> -->
                        </tr>
                        <!-- <tr>
                                <td>3</td>
                                <td>12042018NS</td>
                                <td><a href="#">Gói sản phẩm tuyển dụng nhân sự</a></td>
                                <td>12/04/2018</td>
                                <td><span class="text-danger">12/04/2018</span></td>
                            </tr> -->
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
@endsection