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
    @yield('page_content')
    @include('Web::partials.footer')
    @include('Web::partials.foot_script')
    @yield('custom_js')
</body>

</html>
