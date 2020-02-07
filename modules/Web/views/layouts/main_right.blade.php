<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ isset($page_title) ? $page_title : $global_config['site_name'] }}</title>
    @include('Web::partials.head_link')
    @yield('custom_css')
</head>

<body>
    @include('Web::partials.header')
    @yield('breadcrums')
    <main id="main">
        <div id="content" role="main" class="content-area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                        @yield('page_content')
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <aside class="sidebar">
                            @widgetGroup('SIDEBAR_RIGHT')
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('Web::partials.footer')
    @include('Web::partials.foot_script')
    @yield('custom_js')
</body>

</html>
