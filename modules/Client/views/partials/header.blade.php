<header>
    <div class="header-top">
        <div class="container">
            <div class="d-flex">
                <div class="logo mr-auto">
                    <a href="{{ route('client.index') }}">
                        <img src="{{ asset('assets/client/images/logo-emc.png') }}" alt="logo" title="Công ty TNHH Tư Vấn Quản Lý Doanh Nghiệp EMC">
                    </a>
                    <span class="ml-3"><a href="{{ route('home') }}" class="btn">&larr; Trở về EMC.VN</a></span>
                </div>
                <div class="select-lang my-2 my-lg-0 align-self-center">
                    <a href="#" style="margin-right: 15px; color: #111;" target="_blank">
                        <img src="{{ asset('assets/client/images/cart.svg') }}" alt="cart" title="Giỏ hàng" style="width: 30px;">
                        <span class="ml-1">Giỏ hàng</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class=" header-middle bg-danger">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <span>
                        <button class="navbar-toggler" id="open-left" type="button">
                            <img src="{{ asset('assets/client/images/menu.svg') }} " class=" navigation-menu" alt="" style="width: 20px;">
                        </button>
                    </span>
                    <ul class="navbar-nav ml-auto">
                        <li>
                            <div class="btn-group">
                                <a href="javascrip:;" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-user-circle mr-1"></i> Mitech Center
                                </a>
                                <div class="dropdown-menu user-menu rounded-0 m-0">
                                    <a class="dropdown-item" href="{{ route('client.my_account') }}"><i class="fas fa-user"></i> Tài
                                        khoản</a>
                                    <a class="dropdown-item" href="{{ route('client.history_download') }}"><i class="far fa-file-alt"></i> Quản lý tệp tin</a>
                                    <a class="dropdown-item" href="{{ route('client.recruitments') }}"><i class="far fa-file-alt"></i> Quản lý vị trí đã ứng tuyển</a>
                                    <a class="dropdown-item" href="{{ route('client.change_password') }}"><i class="fas fa-lock"></i>
                                        Đổi mật khẩu</a>
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item text-danger text-center" href="{{ route('logout') }}">Đăng xuất<i class="fas fa-sign-out-alt ml-1"></i></a>
                                </div>
                            </div>
                        </li>

                    </ul>

                </div>
            </nav>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="menu-services">
                <nav class="navbar navbar-expand-lg p-0">
                    <div class="collapse navbar-collapse" id="navbarservices">
                        <button class="navbar-toggler" id="close" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="d-flex justify-content-center w-100">
                            <ul class="navbar-nav ">
                                <li class="nav-item {{ request()->route()->action['as'] == 'client.index' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('client.index') }}">
                                        <span class="link-icon">
                                            <img src="{{ asset('assets/client/images/advice.svg') }}" alt="">
                                        </span>
                                        <span class="link-text">Trang chủ</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->route()->action['as'] == 'client.my_products' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('client.my_products') }}">
                                        <span class="domain-count"><span class="mark-sale">1</span></span>
                                        <span class="link-icon">
                                            <img src="{{ asset('assets/client/images/book-keeper.svg') }}" alt="">
                                        </span>
                                        <span class="link-text">Sản phẩm</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->route()->action['as'] == 'client.requests' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('client.requests') }}">
                                        <span class="domain-count"><span class="mark-sale">3</span></span>
                                        <span class="link-icon">
                                            <img src="{{ asset('assets/client/images/passive-candidate.svg') }}" alt="">
                                        </span>
                                        <span class="link-text">Yêu cầu</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->route()->action['as'] == 'client.orders' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('client.orders') }}">
                                        <span class="link-icon">
                                            <img src="{{ asset('assets/client/images/execution.svg') }}" alt="">
                                        </span>
                                        <span class="link-text">Đơn hàng</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->route()->action['as'] == 'client.tickets' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('client.tickets') }}">
                                        <span class="link-icon">
                                            <img src="{{ asset('assets/client/images/team.svg') }}" alt="">
                                        </span>
                                        <span class="link-text">Hỗ trợ</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>