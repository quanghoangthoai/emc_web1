<?php

use Modules\Product\Models\Product;
use Modules\Request\Models\RequestProduct;
use Modules\Request\Models\Requests;
use Modules\Ticket\Models\Messages;
use Modules\Ticket\Models\Ticket;
use Modules\User\Models\User;

if (!function_exists('mod_ticket_get_html_status')) {
    function mod_ticket_get_html_status($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success">Mới</span>';
        } elseif ($status == 2) {
            return '<span class="badge badge-warning">Đã tiếp nhận</span>';
        } elseif ($status == 3) {
            return '<span class="badge badge-primary">Đang xử lý</span>';
        } elseif ($status == 4) {
            return '<span class="badge badge-info">Đã trả lời</span>';
        } elseif ($status == 5) {
            return '<span class="badge badge-danger">Tạm ngưng</span>';
        } elseif ($status == 6) {
            return '<span class="badge badge-dark">Hoàn tất</span>';
        } elseif ($status == 7) {
            return '<span class="badge badge-secondary">Đợi phản hồi</span>';
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_html_status_customer')) {
    function mod_ticket_get_html_status_customer($status)
    {
        if ($status == 1) {
            return '<span class="text-success">Mới</span>';
        } elseif ($status == 7) {
            return '<span class="text-info">Đã trả lời</span>';
        } elseif ($status == 4) {
            return '<span class="text-secondary">Tin nhắn mới</span>';
        } elseif ($status == 6) {
            return '<span class="text-dark">Hoàn tất</span>';
        }
        return '<span class="text-primary">Đang xử lý</span>';
    }
}

if (!function_exists('mod_ticket_list_status')) {
    function mod_ticket_list_status()
    {
        $data = [
            '1' => 'Mới',
            '2' => 'Đã tiếp nhận',
            '3' => 'Đang xử lý',
            '4' => 'Đã trả lời',
            '7' => 'Đợi phản hồi',
            '5' => 'Tạm ngưng',
            '6' => 'Hoàn tất',
        ];
        return $data;
    }
}

if (!function_exists('mod_ticket_category_display_name')) {
    function mod_ticket_category_display_name($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        if ($ticket['category_id'] == null) {
            return $ticket['category_description'];
        } else {
            return $ticket->category['name'];
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_last_request')) {
    function mod_ticket_get_last_request($id)
    {
        $mess = Messages::where('ticket_id', $id)->latest('reply_at')->first();
        if ($mess) {
            return $mess['content'];
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_last_reply')) {
    function mod_ticket_get_last_reply($id)
    {
        $mess = Messages::where('ticket_id', $id)->latest('reply_at')->first();
        if ($mess) {
            return $mess['reply_at'];
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_last_list_attachment')) {
    function mod_ticket_get_last_list_attachment($id)
    {
        $mess = Messages::where('ticket_id', $id)->latest('reply_at')->first();
        if ($mess) {
            $ar_attach = json_decode($mess['attachments'], true);
            return $ar_attach;
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_list_attachment_history')) {
    function mod_ticket_get_list_attachment_history($reply_at)
    {
        $mess = Messages::where('reply_at', $reply_at)->first();
        if ($mess) {
            $ar_attach = json_decode($mess['attachments'], true);
            return $ar_attach;
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_list_attachment')) {
    function mod_ticket_get_list_attachment($reply_at)
    {
        $mess = Messages::where('reply_at', $reply_at)->first();
        if ($mess) {
            $ar_attach = json_decode($mess['attachments'], true);
            return $ar_attach;
        }
        return '';
    }
}

if (!function_exists('mod_ticket_get_name_file')) {
    function mod_ticket_get_name_file($str)
    {
        $arr = explode("/", $str);
        $n = count($arr);
        return $arr[$n - 1];
    }
}

if (!function_exists('mod_ticket_get_name_check_path')) {
    function mod_ticket_get_name_check_path($str)
    {
        $arr = explode("/", $str);
        $n = count($arr);
        return substr($str, 0, -strlen($arr[$n - 1]));
    }
}

if (!function_exists('mod_ticket_check_role_customer')) {
    function mod_ticket_check_role_customer($user_id)
    {
        $user = User::find($user_id);
        if ($user->hasRole('customer')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('mod_ticket_check_use_product')) {
    function mod_ticket_check_use_product($email, $product_id)
    {
        $request = Requests::where('client_email', $email)->get();
        if (isset($request) && count($request)) {
            foreach ($request as $iReq) {
                if ($iReq['isOrderCreated'] == 1) {
                    $product = RequestProduct::where('request_id', $iReq['id'])->get();
                    foreach ($product as $iPro) {
                        if ($iPro['product_id'] == $product_id) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}

if (!function_exists('mod_ticket_get_name_product')) {
    function mod_ticket_get_name_product($id)
    {
        $product = Product::where('id', $id)->first();
        if (isset($product)) {
            return $product->category->name . ' (' . $product->name . ')';
        }
        return '';
    }
}

if (!function_exists('unique_multidim_array')) {
    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}
