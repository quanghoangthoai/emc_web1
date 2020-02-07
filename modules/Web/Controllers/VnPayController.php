<?php

namespace Modules\Web\Controllers;

use Illuminate\Http\Request;
use System\Core\Controllers\WebController as Controller;

class VnPayController extends Controller
{
    public function getPayment(Request $request)
    {
        if (cms_get_config('enable_vnpay') == 0) die('Tính năng chưa được bật');

        // get id request
        $cusRequest = [
            'id' => 1,
            'code' => 'YC0000002',
            'amount' => '120000',
        ];

        session(['request_id' => $cusRequest['id']]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = cms_get_config('vnpay_tmncode');
        $vnp_HashSecret = cms_get_config('vnpay_hashsecret');
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.result_payment');
        $vnp_TxnRef = $cusRequest['code'];
        $vnp_OrderInfo = $cusRequest['code'];
        $vnp_OrderType = '250000';
        $vnp_Amount = $cusRequest['amount'] * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function getResultPayment(Request $request)
    {
        $url = session('url_prev', '/');
        session()->forget('url_prev');
        if ($request->vnp_ResponseCode == "00") {
            // Xử lý thành công
            // return redirect($url)->with('success', 'Đã thanh toán phí dịch vụ');
            dd('Đã thanh toán phí dịch vụ');
        }
        dd('Lỗi trong quá trình thanh toán phí dịch vụ');
    }
}