<?php

use Modules\Product\Models\Category;


function mod_product_list_category($parent_id = 0, $prefix = '')
{
    $list_category = Category::where('parent_id', $parent_id)->orderBy('order', 'asc')->get()->toArray();
    $result = [];
    foreach ($list_category as $iCategory) {
        $iCategory['prefix'] = $prefix;
        array_push($result, $iCategory);
        $result = array_merge($result, mod_product_list_category($iCategory['id'], $prefix . '------ '));
    }
    return $result;
}

function mod_product_delete_category($id)
{
    $category = Category::find($id);
    if ($category) {
        if ($category->children()->count()) {
            $children_cat = $category->children;
            foreach ($children_cat as $childcat) {
                mod_product_delete_category($childcat['id']);
            }
        }
        $category->delete();
    }
    return true;
}


if (!function_exists('mod_product_get_name_category')) {
    function mod_product_get_name_category($id)
    {
        try {
            if (Category::where('id', $id)->first()) {
                return Category::where('id', $id)->first()->name;
            }
        } catch (\Throwable $th) {
            return null;
        }
    }
}
/***
 * Check Status Product
 */
if (!function_exists('mod_product_get_status_post')) {
    function  mod_product_get_status_post($status = 10)
    {
        switch ($status) {
            case 1:
                return '<span class="text-success"><i class="fa fa-check"></i> Đã xuất bản</span>';
                break;
            case 2:
                return '<span class="text-warning"><i class="fa fa-close"></i> Đã từ chối</span>';
                break;
            case 3:
                return '<span class="text-danger"><i class="fa fa-ban"></i> Ngưng hiệu lực</span>';
                break;
            case 0:
                return '<span class="text-danger"><i class="fa fa-clock-o"></i> Đang chờ duyệt</span>';
                break;
            default:
                return '<span><i class="fa fa-file-o"></i> Bản nháp</span>';
                break;
        }
    }
}

/**
 * Get Product Featurerd
 */
if (!function_exists('mod_product_get_featured')) {
    function mod_product_get_featured($featured = 1)
    {
        switch ($featured) {
            case 1:
                return '<span class="text-success"><i class="fa fa-check"></i> Sản phẩm nổi bật </span>';
                break;

            default:
                return '<span><i class="fa fa-file-o"></i> Chưa là sản phẩm nổi bật</span>';
                break;
        }
    }
}
/**
 * Tree categories
 */
if (!function_exists('mod_product_tree_categories')) {
    function mod_product_tree_categories($parent_id = 0)
    {
        $categories = Category::where('parent_id', $parent_id != 0 ? $parent_id : 0)->orderBy('order', 'asc')->get();
        if (count($categories)) {
            foreach ($categories as $k => $parent) {
                $categories[$k]['subcat'] = Category::where('parent_id', $parent['id'])->orderBy('order', 'asc')->get();
            }
        }
        return $categories;
    }
}

if (!function_exists('mod_product_fix_cat_order')) {
    function mod_product_fix_cat_order($parentid = 0, $order = 0)
    {
        $listCat = Category::select('id')->where('parent_id', $parentid)->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listCat as $cat) {
            ++$order;
            ++$weight;
            Category::where('id', $cat['id'])->update([
                'order' => $weight
            ]);
            $order = mod_product_fix_cat_order($cat['id'], $order);
        }
        return $order;
    }
}