<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ isset($page_title) ? $page_title : (isset($global_config['site_name']) ? $global_config['site_name'] : 'AdminCP') }}</title>
    @include('Admin::layouts.partials.head_link')
    @yield('custom_css')
</head>

<body class="navbar-top {{ $classFullsidebar }}">
    @include('Admin::layouts.partials.header')
    <!-- Page content -->
    <div class="page-content">
        @include('Admin::layouts.partials.sidebar')
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Page header -->
            <div class="page-header page-header-light">

                @yield('page_header')

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            {{ Breadcrumbs::render() }}
                        </div>
                        {{-- <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a> --}}
                    </div>
                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                @yield('page_content')
            </div>
            <!-- /content area -->
            @include('Admin::layouts.partials.footer')
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
    @include('Admin::layouts.partials.foot_script')
    @yield('custom_js')
</body>

</html>
