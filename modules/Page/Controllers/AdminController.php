<?php

namespace Modules\Page\Controllers;

use Illuminate\Http\Request;
use Modules\Page\Models\Page;
use System\Core\Controllers\AdminController as SystemAdminController;


class AdminController extends SystemAdminController
{
    /**
     * Get list page
     */
    public function getListPage()
    {
        $data['listPage'] = Page::orderBy('order', 'asc')->get();
        $data['minOrder'] = Page::min('order');
        $data['maxOrder'] = Page::max('order');
        return view('Page::admin.list', $data);
    }

    /**
     * Get Add Page
     */

    public function getAddPage()
    {
        return view('Page::admin.add');
    }

    /**
     * Post Add Page
     */
    public function postAddPage(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug',
            'content' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'content.required' => 'Chưa nhập nội dung chi tiết'
        ]);

        $maxOrder = Page::max('order');
        Page::create([
            'title' => $request->title,
            'slug' => empty($request->slug) ? str_slug($request->title) : $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
            'order' => $maxOrder ? $maxOrder + 1 : 1
        ]);
        return redirect()->route('mod_page.admin.list_page')->with('flash_data', ['type' => 'success', 'message' => 'Thêm trang thành công']);
    }
    /**
     * edit page
     */
    public function getEdit($id)
    {
        $data['page'] = Page::find($id);
        return view('Page::admin.edit', $data);
    }

    /**
     * post edit page
     */
    public function postEditPage($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,' . $id,
            'content' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
            'content.required' => 'Chưa nhập nội dung'
        ]);

        Page::where('id', $id)->update([
            'title' => $request->title,
            'slug' => empty($request->slug) ? str_slug($request->title) : $request->slug,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $request->image,
            'status' => $request->status,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
        ]);
        return redirect()->route('mod_page.admin.list_page')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật trang thành công']);
    }

    /**
     * delete page
     */
    public function getDeletePage($id)
    {
        Page::where('id', $id)->delete();
        mod_page_fix_page_order();

        return redirect()->route('mod_page.admin.list_page')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    /**
     * Ajax Change page
     */
    public function ajaxChangPage(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        $listPage = Page::where([['id', '!=', $id]])->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listPage as $page) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Page::where('id', $page['id'])->update(['order' => $weight]);
        }
        Page::where('id', $id)->update(['order' => $order]);
        mod_page_fix_page_order();
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function ajaxChangeStatus(Request $request)
    {
        try {
            Page::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }
}