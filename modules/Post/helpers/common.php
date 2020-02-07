<?php

use Modules\Post\Models\Category;

function mod_post_list_category($parent_id = 0, $prefix = '')
{
    $list_category = Category::where('parent_id', $parent_id)->orderBy('order', 'asc')->get()->toArray();
    $result = [];
    foreach ($list_category as $iCategory) {
        $iCategory['prefix'] = $prefix;
        array_push($result, $iCategory);
        $result = array_merge($result, mod_post_list_category($iCategory['id'], $prefix . '------ '));
    }
    return $result;
}

function mod_post_delete_category($id)
{
    $category = Category::find($id);
    if ($category) {
        if ($category->children()->count()) {
            $children_cat = $category->children;
            foreach ($children_cat as $childcat) {
                mod_post_delete_category($childcat['id']);
            }
        }
        if ($category->posts()->count()) {
            $posts = $category->posts;
            foreach ($posts as $post) {
                $post->delete();
            }
        }
        $category->delete();
    }
    return true;
}