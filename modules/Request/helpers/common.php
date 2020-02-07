<?php

use Modules\Product\Models\Category as ProductCategory;
use Modules\Product\Models\Product;
use Modules\Request\Models\Requests;
use Modules\User\Models\User;

if (!function_exists('mod_request_fix_request_order')) {
    function mod_request_fix_request_order()
    {
        $listRequest = Requests::select('id')->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listRequest as $cat) {
            ++$weight;
            Requests::where('id', $cat['id'])->update([
                'order' => $weight
            ]);
        }
        return true;
    }
}
if (!function_exists('mod_request_list_status')) {
    function mod_request_list_status()
    {
        $data = [
            '0' => 'Chưa thanh toán',
            '1' => 'Đã thanh toán'
        ];
        return $data;
    }
}

if (!function_exists('mod_request_get_status_name')) {
    function mod_request_get_status_name($id)
    {
        $data = [
            '0' => 'Chưa thanh toán',
            '1' => 'Đã thanh toán'
        ];
        return $data[$id];
    }
}

if (!function_exists('mod_request_get_payment_name')) {
    function mod_request_get_payment_name($id)
    {
        $data = [
            '0' => 'Tiền mặt',
            '1' => 'Chuyển khoản',
            '2' => 'Khác'
        ];
        return $data[$id];
    }
}

if (!function_exists('mod_request_check_email_user_exist')) {
    function mod_request_check_email_user_exist($email)
    {
        if (User::where('email', $email)->exists()) {
            return true;
        } else
            return false;
    }
}



if (!function_exists('mod_request_get_status')) {
    function mod_request_get_status($id)
    {
        $json = '[
                {"id":0,"status":"Chưa thanh toán","colorClass":"badge badge-warning"},
                {"id":1,"status":"Đã thanh toán","colorClass":"badge badge-success"}
            ]';
        $arr = json_decode($json, true);
        $string = '';
        if ($arr) {
            foreach ($arr as $iArr) {
                if ($iArr['id'] == $id) {
                    $string = '<span class="' . $iArr['colorClass'] . '">' . $iArr['status'] . '</span>';
                    break;
                }
            }
        }
        return $string;
    }
}
if (!function_exists('mod_request_str_limit')) {
    function mod_request_str_limit($text, $num = 10)
    {
        return Str::limit($text, $num);
    }
}

if (!function_exists('mod_request_list_product_category')) {
    function mod_request_list_product_category($parent_id = 0, $prefix = '')
    {
        $list_category = ProductCategory::where('parent_id', $parent_id)->where('status', 1)->orderBy('order', 'asc')->get()->toArray();
        $result = [];
        foreach ($list_category as $iCategory) {
            $iCategory['prefix'] = $prefix;
            array_push($result, $iCategory);
            $result = array_merge($result, mod_product_list_category($iCategory['id'], $prefix . '------ '));
        }
        return $result;
    }
}

function mod_request_get_product_from_array($arrayId)
{
    $shoppingCart =  Product::whereIn('id', $arrayId)->get();
    return $shoppingCart;
}
