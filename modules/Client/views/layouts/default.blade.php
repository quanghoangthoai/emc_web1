<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ isset($page_title) ? $page_title : 'Clients' }}</title>
    @include('Client::partials.head_link')
    @yield('custom_css')
</head>

<body>
    <div id="wrapper">
        @include('Client::partials.header')
        @yield('page_content')
        @include('Client::partials.footer')
        @include('Client::partials.foot_script')
        @yield('custom_js')
    </div>
</body>

</html>
