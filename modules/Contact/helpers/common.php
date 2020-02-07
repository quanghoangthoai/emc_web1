<?php

function mod_contact_get_html_status($status)
{
    if ($status == 1) {
        return '<span class="badge badge-success">Mới</span>';
    } elseif ($status == 2) {
        return '<span class="badge badge-warning">Đã tiếp nhận</span>';
    } elseif ($status == 3) {
        return '<span class="badge badge-primary">Đã phản hồi</span>';
    } elseif ($status == 4) {
        return '<span class="badge badge-danger">Đã hủy</span>';
    }
    return '';
}

function mod_contact_list_service()
{
    return [
        'Hỗ trợ tư vấn đăng ký mới dịch vụ',
        'Hỗ trợ các vấn đề về Đơn hàng thanh toán Online',
        'Hỗ trợ chuyên sâu về Nghiệp vụ kế toán',
        'Hỗ trợ thay đổi Thông tin - Hồ sơ - Hợp đồng',
        'Than phiền - Góp ý',
    ];
}
