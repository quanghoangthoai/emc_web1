<header>
    <div id="header-top">
        <div class="container">
            <div class="d-flex">
                <div class="logo mr-auto">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset($global_config['site_logo'] ?? 'assets/web/images/logo-emc.png') }}" alt="logo" title="Người trợ lý đắc lực cho doanh nghiệp">
                    </a>
                    <span class="ml-3">Người trợ lý đắc lực cho doanh nghiệp</span>
                </div>
                <div class="my-2 my-lg-0 align-self-center">
                    <ul>
                        <li>
                            <a href="#">
                                <span><img src="{{ asset('assets/web/images/hotro.svg') }}" alt=""></span>Hỗ trợ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.index') }}">
                                <span><img src="{{ asset('assets/web/images/dang-nhap.svg') }}" alt=""></span>Tài khoản
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('mod_request.web.view-cart') }}">
                                <span><img src="{{ asset('assets/web/images/gio-hang.svg') }}" alt=""></span>Giỏ hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="header-bottom">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <button type=" button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                </button>
                <div id="navbarContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item active">
                            <a href="" class="nav-link text-uppercase">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a href="about.html" class="nav-link text-uppercase">Giới thiệu</a>
                        </li> -->
                        <li class="nav-item dropdown megamenu"><a id="megamneu" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-uppercase">Tư vấn pháp lý</a>
                            <div aria-labelledby="megamneu" class="dropdown-menu border-0 p-0 m-0">
                                <div class="container p-0">
                                    <div class="row bg-white rounded-0 m-0">
                                        <div class="col-xs-12 col-lg-12">
                                            <h6 class="text-uppercase">Tư vấn pháp lý cho doanh nghiệp</h6>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <p>Chúng tôi nguyện làm hết sức mình một cách sáng tạo và đầy ý nghĩa, trên cơ sở cùng có lợi để trở thành nới đáng tin cậy nhất Việt Nam, ngang tầm thế giới, nhằm giúp doanh nghiệp trở nên chuyên nghiệp và hiệu quả hơn</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thành lập doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thay đổi giấy phép kinh doanh</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">M&A - Mua bán doanh nghiệp</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Dịch vụ giải thể doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Bảo hộ thương hiệu</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Giấy phép cho người nước ngoài</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown megamenu"><a id="megamneu" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-uppercase">Dịch vụ kế toán</a>
                            <div aria-labelledby="megamneu" class="dropdown-menu border-0 p-0 m-0">
                                <div class="container p-0">
                                    <div class="row bg-white rounded-0 m-0">
                                        <div class="col-xs-12 col-lg-12">
                                            <h6 class="text-uppercase">Dịch vụ kế toán</h6>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <p>Chúng tôi nguyện làm hết sức mình một cách sáng tạo và đầy ý nghĩa, trên cơ sở cùng có lợi để trở thành nới đáng tin cậy nhất Việt Nam, ngang tầm thế giới, nhằm giúp doanh nghiệp trở nên chuyên nghiệp và hiệu quả hơn</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">

                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thành lập doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thay đổi giấy phép kinh doanh</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">M&A - Mua bán doanh nghiệp</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Dịch vụ giải thể doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Bảo hộ thương hiệu</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Giấy phép cho người nước ngoài</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown megamenu"><a id="megamneu" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-uppercase">Dịch vụ tuyển dụng</a>
                            <div aria-labelledby="megamneu" class="dropdown-menu border-0 p-0 m-0">
                                <div class="container p-0">
                                    <div class="row bg-white rounded-0 m-0">
                                        <div class="col-xs-12 col-lg-12">
                                            <h6 class="text-uppercase">Dịch vụ tuyển dụng</h6>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <p>Chúng tôi nguyện làm hết sức mình một cách sáng tạo và đầy ý nghĩa, trên cơ sở cùng có lợi để trở thành nới đáng tin cậy nhất Việt Nam, ngang tầm thế giới, nhằm giúp doanh nghiệp trở nên chuyên nghiệp và hiệu quả hơn</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">

                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thành lập doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thay đổi giấy phép kinh doanh</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">M&A - Mua bán doanh nghiệp</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Dịch vụ giải thể doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Bảo hộ thương hiệu</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Giấy phép cho người nước ngoài</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown megamenu"><a id="megamneu" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-uppercase">Tư vấn quản lý</a>
                            <div aria-labelledby="megamneu" class="dropdown-menu border-0 p-0 m-0">
                                <div class="container p-0">
                                    <div class="row bg-white rounded-0 m-0">
                                        <div class="col-xs-12 col-lg-12">
                                            <h6 class="text-uppercase">Tư vấn quản lý</h6>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <p>Chúng tôi nguyện làm hết sức mình một cách sáng tạo và đầy ý nghĩa, trên cơ sở cùng có lợi để trở thành nới đáng tin cậy nhất Việt Nam, ngang tầm thế giới, nhằm giúp doanh nghiệp trở nên chuyên nghiệp và hiệu quả hơn</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">

                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thành lập doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thay đổi giấy phép kinh doanh</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">M&A - Mua bán doanh nghiệp</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Dịch vụ giải thể doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Bảo hộ thương hiệu</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Giấy phép cho người nước ngoài</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown megamenu"><a id="megamneu" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-uppercase">Tái cấu trúc</a>
                            <div aria-labelledby="megamneu" class="dropdown-menu border-0 p-0 m-0">
                                <div class="container p-0">
                                    <div class="row bg-white rounded-0 m-0">
                                        <div class="col-xs-12 col-lg-12">
                                            <h6 class="text-uppercase">Tái cấu trúc</h6>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <p>Chúng tôi nguyện làm hết sức mình một cách sáng tạo và đầy ý nghĩa, trên cơ sở cùng có lợi để trở thành nới đáng tin cậy nhất Việt Nam, ngang tầm thế giới, nhằm giúp doanh nghiệp trở nên chuyên nghiệp và hiệu quả hơn</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">

                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thành lập doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Tư vấn thay đổi giấy phép kinh doanh</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">M&A - Mua bán doanh nghiệp</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-12 col-lg-4 mb-4">
                                            <ul class="list-unstyled">
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Dịch vụ giải thể doanh nghiệp</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Bảo hộ thương hiệu</a></li>
                                                <li class="nav-item"><a href="" class="nav-link text-small pb-0 ">Giấy phép cho người nước ngoài</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- <li class="nav-item"><a href="" class="nav-link text-uppercase">Tin tức</a></li>
                        <li class="nav-item"><a href="" class="nav-link text-uppercase">Liên hệ</a></li> -->
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
