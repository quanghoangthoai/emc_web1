<?php

namespace Modules\Post\Controllers;

use Modules\Post\Models\Post;
use System\Core\Controllers\WebController as SystemWebController;

class WebController extends SystemWebController
{
    public function getMainPost()
    {
        return redirect()->route('home');
    }

    public function getDetailPost($slug)
    {
        $data['post'] = Post::where('slug', $slug)->first();
        $data['page_title'] =   $data['post']->title;
        $id = $data['post']->id;
        $module = 'Post';
        foreach (mod_comment_get_data_comment($id, $module) as $key => $value) {
            $data[$key] = $value;
        }
        return view('Post::web.detail_post', $data);
    }
    public static function viewCategory($category)
    {
        $data['category'] = $category;
        $data['listPosts'] = $category->posts()->orderBy('id', 'desc')->paginate(10);
        $data['page_title'] = $category['title'];
        return view('Post::web.view_category', $data);
    }
}
