<!-- Main sidebar: sidebar-fixed  -->
<div class="sidebar sidebar-light sidebar-main sidebar-fixed sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        <span class="font-weight-semibold">DANH MỤC CHỨC NĂNG</span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->route()->action['as'] == 'dashboard' ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>
                            Bảng điều khiển
                        </span>
                    </a>
                </li>
                <!-- Quick actions -->
                {{-- <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">THAO TÁC NHANH</div> <i class="icon-menu" title="Main"></i>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-pencil3"></i> <span>Menu cấp 1</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Menu cấp 1">
                        <li class="nav-item"><a href="#" class="nav-link">Menu cấp 2</a></li>
                    </ul>
                </li> --}}
                <!-- /quick actions -->

                <!-- Modules -->
                @php
                $route_name = request()->route()->action['as'];
                $dashboard_menu = cms_dashboard_menu();
                @endphp
                @if (count($dashboard_menu) > 0)
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">DANH MỤC CHỨC NĂNG</div> <i class="icon-menu" title="Module"></i>
                </li>
                @php
                $current_module = isset(request()->route()->action['module']) ? request()->route()->action['module'] : '';
                @endphp
                @foreach ($dashboard_menu as $menu_module)
                <li class="nav-item nav-item-submenu {{ $current_module == $menu_module['module'] ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="javascript:;" class="nav-link"><i class="{{ $menu_module['icon'] }}"></i>
                        <span>{{ $menu_module['title'] }}</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="{{ $menu_module['title'] }}">
                        @foreach ($menu_module['submenu'] as $submenu)
                        <li class="nav-item">
                            <a href="{{ route($submenu['route']) }}" class="nav-link {{ $route_name == $submenu['route'] ? 'active' : '' }}">
                                {!! $submenu['title'] !!}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
                @endif
                <!-- /modules -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
