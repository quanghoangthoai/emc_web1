@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="detail-ticket">
                <h3 class="title">Đơn hàng</h3>
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="w-25">Mã đơn hàng:</td>
                                <td>12418NS</td>
                            </tr>
                            <tr>
                                <td class="w-25">Trạng thái:</td>
                                <td><span class="text-success">Hoàn thành</span></td>
                            </tr>
                            <tr>
                                <td class="w-25">Ngày khởi tạo:</td>
                                <td>20/07/2018</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table id="" class="table " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">Danh mục</th>
                                    <th class="th-sm">Tên sản phẩm</th>
                                    <th class="th-sm">Nội dung</th>
                                    <th class="th-sm">Thời gian</th>
                                    <th class="th-sm">Tổng chi phí</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="https://www.emcvn.vn/vn" target="_blank">Tư vấn</a></td>
                                    <td><a href="https://www.emcvn.vn/vn" target="_blank">Tư vấn pháp lý</a></td>
                                    <td>Đăng ký mới</td>
                                    <td>1 năm</td>
                                    <td>4.870.800 VNĐ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="w-75 text-right">Giá chưa thuế:</td>
                                <td class="text-right"><b>4.870.800 VNĐ</b></td>
                            </tr>
                            <tr>
                                <td class="w-75 text-right">Thuế:</td>
                                <td class="text-right"><b>487.080 VNĐ</b></td>
                            </tr>
                            <tr>
                                <td class="w-75 text-right">Tổng giá trị:</td>
                                <td class="text-right"><b>5.358.600 VNĐ</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection