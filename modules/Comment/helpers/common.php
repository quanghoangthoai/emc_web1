<?php

use Modules\Comment\Models\CommentModule;
use Modules\Comment\Models\Comment;

if (!function_exists('mod_comment_get_module_id')) {
    function mod_comment_get_module_id($name_module)
    {
        $list_mod = CommentModule::where('status', 1)->get();
        $module_id = null;
        if ($list_mod != null && count($list_mod)) {
            foreach ($list_mod as $iMod) {
                if ($iMod['name'] == $name_module) {
                    $module_id = $iMod['id'];
                }
            }
        }
        if ($module_id != null) {
            return $module_id;
        }
        return null;
    }
}

if (!function_exists('mod_comment_get_module_class')) {
    function mod_comment_get_module_class($id)
    {
        $data = CommentModule::where('id', $id)->first();
        if (isset($data)) {
            return $data->name;
        }
        return '';
    }
}

if (!function_exists('mod_comment_get_check_comment')) {
    function mod_comment_get_check_comment($name_module)
    {
        $list_mod = CommentModule::where('status', 1)->get();
        $check_comment = false;
        if ($list_mod != null && count($list_mod)) {
            foreach ($list_mod as $iMod) {
                if ($iMod['name'] == $name_module && auth('web')->id() != null) {
                    $check_comment = true;
                }
            }
        }
        if ($check_comment == true) {
            return true;;
        }
        return false;
    }
}


if (!function_exists('mod_comment_get_content_comment')) {
    function mod_comment_get_content_comment($id, $module_id)
    {
        $data['comments'] = Comment::where('post_id', $id)->where('module_id', $module_id)->orderBy('created_at', 'desc')->get();
        return $data['comments'];
    }
}

if (!function_exists('mod_comment_get_list_module_comment_active')) {
    function mod_comment_get_list_module_comment_active()
    {
        $arr_mod = [];
        $list_mod = CommentModule::where('status', 1)->get();
        foreach ($list_mod as $iMod) {
            $arr_mod[] = $iMod['name'];
        }

        return $arr_mod;
    }
}


if (!function_exists('mod_comment_get_data_comment')) {
    function mod_comment_get_data_comment($id, $module)
    {
        $data['link'] = base64_encode(url()->current());
        $data['module_id'] = mod_comment_get_module_id($module);
        $data['module'] = $module;
        $data['check_comment'] = mod_comment_get_check_comment($module);
        $data['comments'] = mod_comment_get_content_comment($id, $data['module_id']);
        return $data;
    }
}
