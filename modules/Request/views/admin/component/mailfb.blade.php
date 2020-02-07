<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <style>
        #frm {
            border: solid gray 1px;
            width: 50%;
            height: auto;
            margin: 10px auto;
            background: white;
            border-radius: 5px;
            padding: 10px;
        }

        .h4 {
            text-align: center;
        }

        .row {
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="frm">
        <div class="row">
            <div style="float: left;width: 20%;">
                <img src="https://www.emcvn.vn/images/theme1/emc-logo-big.png" alt="" width="60px" height="50px">
            </div>
            <div style="float: right;width: 80%;">
                <h4 class="h4">CÔNG TY EMC TRÂN TRỌNG THÔNG BÁO</h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <p>&emsp;Xin chào quý khách hàng, lời đầu tiên cho phép công ty chúng tôi gửi lời cảm ơn sâu sắc đến quý
                khách hàng vì đã quan tâm tới những dịch vụ của công ty chúng tôi!</p>
            <p>Xin chào: {{$name}}</p>
            <p>Email: {{$email}}</p>
            <p>Nội dung thông báo: Tạo tài khoản người dùng thành công</p>
            <p>Tài khoản: <b>{{$email}}</b></p>
            <p>Mật khẩu: <b>{{$password}}</b></p>
        </div>

    </div>
</body>

</html>