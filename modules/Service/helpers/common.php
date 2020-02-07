<?php

use Modules\Service\Models\Category;

function mod_service_list_category($parent_id = 0, $prefix = '')
{
    $list_category = Category::where('parent_id', $parent_id)->orderBy('order', 'asc')->get()->toArray();
    $result = [];
    foreach ($list_category as $iCategory) {
        $iCategory['prefix'] = $prefix;
        array_push($result, $iCategory);
        $result = array_merge($result, mod_service_list_category($iCategory['id'], $prefix . '------ '));
    }
    return $result;
}

function mod_service_delete_category($id)
{
    $category = Category::find($id);
    if ($category) {
        if ($category->children()->count()) {
            $children_cat = $category->children;
            foreach ($children_cat as $childcat) {
                mod_service_delete_category($childcat['id']);
            }
        }
        $category->delete();
    }
    return true;
}


if (!function_exists('mod_service_list_status')) {
    function mod_service_list_status()
    {
        $data = [
            '0' => 'Tạm ngưng',
            '1' => 'Hoạt động'
        ];
        return $data;
    }
}
