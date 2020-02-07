<?php

namespace Modules\Post\Controllers;

use System\Core\Controllers\AdminController as SystemAdminController;
use Illuminate\Http\Request;
use Modules\Post\Models\Category;
use Modules\Post\Models\Post;

class AdminController extends SystemAdminController
{
    /**
     * list category
     */
    public function getListCategory()
    {
        $data['listCategory'] = mod_post_list_category();
        return view('Post::admin.category.list', $data);
    }

    /**
     * POST Add category
     */
    public function postAddCategory(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:post_categories,slug',

        ], [
            'title.required' => 'Chưa nhập tên danh mục',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
        ]);

        $new_category = Category::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
            'image' => $request->image,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'status' => $request->status
        ]);
        $new_category->fill(['order' => $new_category['id']])->save();

        return redirect()->route('mod_post.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Thêm danh mục thành công']);
    }

    /**
     * GET Edit category
     */
    public function getEditCategory($id)
    {

        $data['category_edit'] = Category::find($id);
        if ($data['category_edit']) {
            $data['listCategory'] = mod_post_list_category();
            return view('Post::admin.category.edit', $data);
        }

        return redirect()->route('mod_post.admin.list_category')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy danh mục để sửa']);
    }

    public function postEditCategory($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:post_categories,slug,' . $id,

        ], [
            'title.required' => 'Chưa nhập tên danh mục',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
        ]);

        Category::where('id', $id)->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
            'image' => $request->image,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'status' => $request->status
        ]);

        return redirect()->route('mod_post.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật danh mục thành công']);
    }
    /**
     * GET Delete category
     */
    public function getDeleteCategory($id)
    {
        mod_post_delete_category($id);
        return redirect()->route('mod_post.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa danh mục và tất cả dữ liệu liên quan']);
    }

    public function ajaxChangeOrderCategory(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        Category::where('id', $id)->update(['order' => $order]);
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function ajaxChangeStatusCategory(Request $request)
    {
        try {
            Category::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    /**
     * GET List Posts
     */
    public function getListPost()
    {
        $data['listPost'] = Post::orderBy('id', 'desc')->get();
        return view('Post::admin.post.list', $data);
    }

    /**
     * GET Add a new post
     */
    public function getAddPost()
    {
        if (Category::count() == 0) {
            return redirect()->route('mod_post.admin.list_category')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng thêm danh mục trước']);
        }
        $data['listCategory'] = mod_post_list_category();
        return view('Post::admin.post.add', $data)->withShortcodes();
    }

    /**
     * post add post
     */
    public function postAddPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
            'category_id' => 'required',

        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'content.required' => 'Chưa nhập nội dung',
            'category_id.required' => 'Chưa chọn danh mục',

        ]);

        Post::create([
            'title' => $request->title,
            'slug' => empty($request->slug) ? str_slug($request->title) : $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'source' => $request->source,
            'category_id' => $request->category_id,
            'author' => $request->author,
            'tags' => $request->tags,
            'featured' => $request->has('featured') ? 1 : 0,
            'created_by' => auth('admin')->id(),
            'seo_title' => $request->seo_title,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'status' => $request->status
        ]);

        return redirect()->route('mod_post.admin.list_post')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm bài viết']);
    }

    /**
     * edit post
     */
    public function getEditPost($id)
    {
        $data['post'] = Post::find($id);
        $data['listCategory'] = mod_post_list_category();
        return view('Post::admin.post.edit', $data);
    }

    /**
     * post add post
     */
    public function postEditPost($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug,' . $id,
            'content' => 'required',
            'category_id' => 'required',

        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'content.required' => 'Chưa nhập nội dung',
            'category_id.required' => 'Chưa chọn danh mục',

        ]);

        Post::where('id', $id)->update([
            'title' => $request->title,
            'slug' => empty($request->slug) ? str_slug($request->title) : $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'source' => $request->source,
            'category_id' => $request->category_id,
            'author' => $request->author,
            'tags' => $request->tags,
            'featured' => $request->has('featured') ? 1 : 0,
            'created_by' => auth('admin')->id(),
            'seo_title' => $request->seo_title,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'status' => $request->status
        ]);

        return redirect()->route('mod_post.admin.list_post')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    /**
     * delete post
     */
    public function getDeletePost($id)
    {
        Post::where('id', $id)->delete();
        return redirect()->route('mod_post.admin.list_post')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    public function ajaxChangeStatusPost(Request $request)
    {
        try {
            Post::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }
}