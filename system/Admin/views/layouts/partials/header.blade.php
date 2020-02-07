<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark bg-indigo navbar-slide-top navbar-topheader fixed-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                <i class="icon-paragraph-justify3"></i>
            </a>
        </li>
    </ul>
    <span class="navbar-text ml-md-3">
        <i class="icon-alarm font-size-sm mr-1 font-weight-semibold"></i>
        <span id="timer_header"></span>
    </span>
    <div class="navbar-brand d-flex justify-content-center">
        <a href="{{ route('dashboard') }}" class="d-block">
            <strong>EMC</strong>
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">

        <ul class="navbar-nav ml-md-auto">
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-cogs mr-1"></i>
                    Quản trị
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-body p-2">
                        <div class="row no-gutters">

                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.setting_info') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">THÔNG TIN<br>WEBSITE</div>
                                </a>
                            </div>

                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.setting_system') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-cogs fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">THIẾT LẬP<br>HỆ THỐNG</div>
                                </a>
                            </div>
                            @if (in_array('User', $active_modules))
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('mod_user.admin.list_department') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fas fa-user-tie fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">QUẢN LÝ<br>PHÒNG BAN</div>
                                </a>
                            </div>
                            @endif
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.list_role') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-users fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">VAI TRÒ<br>QUYỀN HẠN</div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.files') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-file-image fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">QUẢN LÝ<br>FILE</div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.list_backup') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-database fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">SAO LƯU<br>DỮ LIỆU</div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.addons') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-plug fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">QUẢN LÝ<br>TIỆN ÍCH</div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.list_activity_log') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-history fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">NHẬT KÝ<br>HOẠT ĐỘNG</div>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.list_email_templates') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fa fa-envelope fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">QUẢN LÝ<br>MẪU EMAIL</div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.layouts') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fas fa-desktop fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">THIẾT LẬP<br>LAYOUT</div>
                                </a>
                            </div>
                            @if (in_array('Menu', $active_modules))
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('mod_menu.admin.list_menu') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="icon-tree7 fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">QUẢN LÝ<br>MENU</div>
                                </a>
                            </div>
                            @endif
                            <div class="col-6 col-sm-3">
                                <a href="{{ route('cms.admin.list_widget') }}" class="d-block text-default text-center ripple-dark rounded p-3">
                                    <i class="fas fa-th-list fa-2x"></i>
                                    <div class="font-size-sm font-weight-semibold text-uppercase mt-2">QUẢN LÝ<br>WIDGET</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown notifications-menu">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <span class="badge badge-danger" id="num_notification"></span>
                    <i class="icon-bell2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350" id="notification_load"></div>
            </li>

            @if (module_check_active('Web'))
            <li class="nav-item">
                <a target="_blank" href="{{ route('home') }}" class="navbar-nav-link">
                    <i class="fa fa-globe"></i>
                    <span class="ml-2">Xem website</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('mod_user.admin.logout') }}" class="navbar-nav-link">
                    <i class="icon-switch2"></i>
                    <span class="d-md-none ml-2">Thoát</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
