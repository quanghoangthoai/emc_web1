@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="list-ticket">
                <h3 class="title">Danh sách yêu cầu hỗ trợ</h3>
                <div class="text-right mb-3">
                    <button type="button" class="btn btn-success" id="" onclick="location.href='{{ route('client.add_ticket') }}'"><i class="fas fa-plus"></i> Tạo yêu cầu</button>
                </div>
                <table id="dtBasicExample" class="table " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Tiêu đề</th>
                            <th class="th-sm">Ngày khởi tạo</th>
                            <th class="th-sm">Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{ route('client.detail_ticket') }}">Hỗ trợ gia hạn hợp đồng</a></td>
                            <td>17/06/2019 08:34</td>
                            <td><span class="text-danger">Chưa xử lý</span></td>
                        </tr>
                        <tr>
                            <td><a href="{{ route('client.detail_ticket') }}">Hỗ trợ dịch vụ chữ ký số</a></td>
                            <td>02/05/2019 09:34</td>
                            <td><span class="text-primary">Đang xử lý</span></td>
                        </tr>
                        <tr>
                            <td><a href="{{ route('client.detail_ticket') }}">Hỗ trợ dịch vụ tuyển dụng nhân sự</a></td>
                            <td>24/02/2019 08:00</td>
                            <td><span class="text-success">Đã xử lý</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
@endsection