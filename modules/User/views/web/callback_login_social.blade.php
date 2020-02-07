<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chuyển hướng đăng nhập...</title>
    <script type="text/javascript" src="{{ asset('assets/web/js/jquery.js') }}"></script>
</head>

<body>
    <script>
        $(document).ready(() => {
            window.opener.callback_login_social('{!! $result !!}');
            window.close();
        });
    </script>
</body>

</html>
