<?php

use Illuminate\Support\Str;
use Modules\Library\Models\Category;
use Modules\Library\Models\Document;
use Modules\Library\Models\History;

if (!function_exists('mod_library_list_category')) {
    function mod_library_list_category($parent_id = 0, $prefix = '')
    {
        $list_category = Category::where('parent_id', $parent_id)->orderBy('id', 'asc')->get()->toArray();
        $result = [];
        foreach ($list_category as $iCategory) {
            $iCategory['prefix'] = $prefix;
            array_push($result, $iCategory);
            $result = array_merge($result, mod_library_list_category($iCategory['id'], $prefix . '------ '));
        }
        return $result;
    }
}

if (!function_exists('mod_library_delete_category')) {
    function mod_library_delete_category($id)
    {
        $category = Category::find($id);
        if ($category) {

            if ($category->children()) {
                $children_cat = $category->children();
                foreach ($children_cat as $childcat) {
                    mod_library_delete_category($childcat['id']);
                }
            }

            if ($category->document()->get()) {
                foreach ($category->document()->get() as $iDoc) {
                    mod_library_delete_document($iDoc['id']);
                }
            }

            $category->delete();
        }
        return true;
    }
}

if (!function_exists('mod_library_delete_document')) {
    function mod_library_delete_document($id)
    {
        History::Where('document_id', $id)->delete();
        Document::Where('id', $id)->delete();
        return true;
    }
}

if (!function_exists('mod_library_get_list_format_type  ')) {
    function mod_library_get_list_format_type()
    {
        $data = [
            '1' => 'Văn bản',
            '2' => 'Multimedia'
        ];
        return $data;
    }
}

if (!function_exists('mod_library_get_list_format_type_name')) {
    function mod_library_get_list_format_type_name($id)
    {
        $data = [
            '1' => 'Văn bản',
            '2' => 'Multimedia'
        ];

        return $data[$id];
    }
}


if (!function_exists('mod_library_list_parent_category')) {
    function mod_library_list_parent_category()
    {
        $data = Category::where('parent_id', 0)->pluck('id', 'name')->all();
        return  $data;
    }
}


function mod_library_tree_categories($parent_id = 0)
{
    $categories = Category::where('parent_id', $parent_id != 0 ? $parent_id : 0)->orderBy('id', 'asc')->get();
    if (count($categories)) {
        foreach ($categories as $k => $parent) {
            $categories[$k]['subcat'] = Category::where('parent_id', $parent['id'])->orderBy('id', 'asc')->get();
        }
    }
    return $categories;
}
if (!function_exists('mod_library_list_document_type')) {
    function mod_library_list_document_type()
    {
        $data = [
            '1' => 'Văn bản quy phạm pháp luật',
            '2' => 'Văn bản nội bộ',
            '3' => 'Hình ảnh',
            '4' => 'Âm thanh',
            '5' => 'Video'
        ];
        return $data;
    }
}

if (!function_exists('mod_library_get_document_type')) {
    function mod_library_get_document_type($id)
    {
        $data = [
            '1' => 'Văn bản quy phạm pháp luật',
            '2' => 'Văn bản nội bộ',
            '3' => 'Hình ảnh',
            '4' => 'Âm thanh',
            '5' => 'Video'
        ];
        return $data[$id];
    }
}

if (!function_exists('mod_library_list_text_type')) {
    function mod_library_list_text_type()
    {
        $data = [
            '1' => 'Nghị định',
            '2' => 'Thông tư',
            '3' => 'Công văn',
            '4' => 'Quyết định'
        ];
        return $data;
    }
}

if (!function_exists('mod_library_get_text_type')) {
    function mod_library_get_text_type($id)
    {
        $data = [
            '1' => 'Nghị định',
            '2' => 'Thông tư',
            '3' => 'Công văn',
            '4' => 'Quyết định'
        ];
        return $data[$id];
    }
}

function mod_library_get_category_name($id)
{
    $category = (Category::find($id));
    return $category->name;
}
function mod_library_str_limit($text, $num)
{
    return Str::limit($text, $num);
}
function mod_library_get_name_status_download($n)
{
    if ($n == 0) {
        return "<i class='fa fa-times-circle mr-1' style='font-size:12px;color:red'></i><i style='color:red'>Không thành công</i>";
    }
    return "<i class='fa fa-check mr-1' style='font-size:12px;color:#4caf50'></i><i style='color:#4caf50'>Thành công</i>";
}

function mod_library_format_date($input, $type)
{
    return Carbon\Carbon::parse($input)->format($type);
}
