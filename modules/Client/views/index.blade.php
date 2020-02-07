@extends('Client::layouts.default')
@section('page_content')
<main id="main">
    <div id="content" role="main" class="content-area">
        <div class="container">
            <section id="intro-home">
                <div class="account-content">
                    <p>Xin chào <strong>Mitech Center</strong></p>
                    <p>Từ trang khách hàng bạn có thể xem những <a href="{{ route('client.my_products') }}">Sản phẩm đang sử dụng</a>, quản lý <a href="{{ route('client.requests') }}">Yêu cầu mới</a>, quản lý <a href="{{ route('client.orders') }}">Đơn hàng</a>, thay đổi <a href="{{ route('client.my_account') }}">Thông tin tài khoản</a>, thay đổi <a href="{{ route('client.change_password') }}">Mật khẩu</a> và <a href="{{ route('client.add_ticket') }}">Gửi yêu cầu hỗ trợ</a>.</p>
                </div>
                <div class="dashboard-links">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="item">
                                <a href="{{ route('client.my_products') }}">
                                    <span class="img"><img class="" src="assets/client/images/file (1).svg" width="40" alt="Card image cap"></span>
                                    <span>Sản phẩm đã đăng ký</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="item">
                                <a href="{{ route('client.requests') }}">
                                    <span class="img"><img class="" src="assets/client/images/file.svg" width="40" alt="Card image cap"></span>
                                    <span>Yêu cầu mới</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="item">
                                <a href="{{ route('client.orders') }}">
                                    <span class="img"><img class="" src="assets/client/images/choices.svg" width="40" alt="Card image cap"></span>
                                    <span>Đơn hàng</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="item">
                                <a href="{{ route('client.my_account') }}">
                                    <span class="img"><img class="" src="assets/client/images/information.svg" width="40" alt="Card image cap"></span>
                                    <span>Thông tin tài khoản</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="item">
                                <a href="{{ route('client.tickets') }}">
                                    <span class="img"><img class="" src="assets/client/images/operator-avatar.svg" width="40" alt="Card image cap"></span>
                                    <span>Hỗ trợ</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection