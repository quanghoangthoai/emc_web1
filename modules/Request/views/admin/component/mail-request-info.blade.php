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

        .table {
            border: 1px solid black;
            width: 100%;
            text-align: center
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
            <p>Nội dung thông báo: Thông tin đơn hàng của quý khách</p>
            <p>Sản phẩm yêu cầu</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listProduct as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ number_format($value['price']) }} đ</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">Tổng(Chưa VAT):</td>
                        <td>{{ number_format($iRequest['total']) }} đ</td>
                    </tr>
                    <tr>
                        <td colspan="2">Khuyến mãi: </td>
                        <td colspan="2">{{ $iRequest['sale_percent'] }} %</td>
                    </tr>
                    <tr>
                        <td colspan="2">VAT:</td>
                        <td>{{ $iRequest['vat_percent'] }} %</td>
                    </tr>
                    <tr>
                        <td colspan="2">Thanh toán:</td>
                        <td>{{ number_format($iRequest['payment']) }} đ</td>
                    </tr>
                    <tr>
                        <td colspan="2">Phương thức thanh toán:</td>
                        <td>{{ $payment_method }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="credit-card">
                <div><b>THÔNG TIN TÀI KHOẢN NGÂN HÀNG</b></div>
                <div class="card-company"><b>Tên ngân hàng:</b> Ngân hàng VCB</div>
                <div class="card-number">
                    <div class="digit-group"><b>Số tài khoản:</b> 4141 7204 9012 0029</div>
                </div>
                <div class="card-number">
                    <div class="digit-group"><b>Số ĐT liên hệ:</b> Di động: 123.456.789 - Hotline: 123.456.789</div>
                </div>
            </div>
        </div>




    </div>
</body>

</html>