<?php

namespace Modules\Menu\Controllers;

use Illuminate\Http\Request;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\Menuitem;
use System\Core\Controllers\AdminController as SystemAdminController;

class AdminController extends SystemAdminController
{
    public function getList()
    {
        $listMenu = Menu::all();
        foreach ($listMenu as $k => $menu) {
            $listMenu[$k]['listItem'] = Menuitem::where('menu_id', $menu['id'])->get();
        }
        $data['listMenu'] = $listMenu;
        return view('Menu::admin.menu.list', $data);
    }

    public function getAddMenu()
    {
        return view('Menu::admin.menu.add');
    }

    public function postAddMenu(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255'
        ], [
            'title.required' => 'Chưa nhập tên mục',
            'title.max' => 'Tên mục không vượt quá 255 ký tự'
        ]);
        Menu::create(['title' => $request->title]);

        return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm dữ liệu']);
    }

    public function getEditMenu($id)
    {
        $data['menu'] = Menu::find($id);
        if ($data['menu']) {
            return view('Menu::admin.menu.edit', $data);
        }

        return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'warning', 'message' => 'Không tìm thấy dữ liệu để sửa']);
    }

    public function postEditMenu($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:255'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'title.max' => 'Tiêu đề không vượt quá 255 ký tự'
        ]);

        Menu::where('id', $id)->update(['title' => $request->title]);

        return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    public function getDeleteMenu($id)
    {
        Menuitem::where('menu_id', $id)->delete();
        Menu::where('id', $id)->delete();

        return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    public function getListItem($id, Request $request)
    {
        $data['menu'] = Menu::find($id);
        if ($data['menu']) {
            $parent_id = $request->query('parent_id', 0);
            $data['minOrder'] = Menuitem::where([['menu_id', '=', $id], ['parent_id', '=', $parent_id]])->min('order');
            $data['maxOrder'] = Menuitem::where([['menu_id', '=', $id], ['parent_id', '=', $parent_id]])->max('order');
            $data['listItem'] = Menuitem::where([['menu_id', '=', $id], ['parent_id', '=', $parent_id]])->orderBy('order')->get();
            if (count($data['listItem']) > 0) {
                foreach ($data['listItem'] as $k => $item) {
                    $data['listItem'][$k]['numsubmenu'] = Menuitem::where([['menu_id', '=', $id], ['parent_id', '=', $item['id']]])->count();
                    $data['listItem'][$k]['group_view'] = json_decode($item['group_view'], true);
                }
            }
            return view('Menu::admin.item.list', $data);
        }
        return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'warning', 'message' => 'Không tìm thấy khối menu']);
    }

    public function getAddItem($id)
    {
        $data['menu'] = Menu::find($id);
        if (!$data['menu']) {
            return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'warning', 'message' => 'Không tìm thấy khối menu']);
        }
        return view('Menu::admin.item.add', $data);
    }

    public function postAddItem($id, Request $request)
    {
        $data['menu'] = Menu::find($id);
        if (!$data['menu']) {
            return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'warning', 'message' => 'Không tìm thấy khối menu']);
        }
        $request->validate([
            'title' => 'required|max:255',
            'link' => 'required|max:255',
            'long_title' => 'max:255'
        ], [
            'title.required' => 'Chưa nhập tên mục',
            'title.max' => 'Tên mục không vượt quá 255 ký tự',
            'link.required' => 'Chưa nhập đường dẫn liên kết',
            'link.max' => 'Đường dẫn liên kết không được vượt quá 255 ký tự',
            'long_title.max' => 'Tiêu đề dài không được vượt quá 255 ký tự'
        ]);
        $maxOrder = Menuitem::where([['menu_id', '=', $id], ['parent_id', '=', $request->parent_id]])->max('order');
        Menuitem::create([
            'title' => $request->title,
            'link' => $request->link,
            'parent_id' => $request->parent_id,
            'target' => $request->target,
            'menu_id' => $id,
            'module' => (!empty($request->module) && !empty($request->item)) ? $request->module : null,
            'order' => $maxOrder ? $maxOrder + 1 : 1,
            'long_title' => $request->long_title,
            'content' => $request->content
        ]);

        return redirect()->route('mod_menu.admin.list_menu_item', $id)->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm dữ liệu']);
    }

    public function getEditItem($id)
    {

        $data['item'] = Menuitem::find($id);
        if (!$data['item']) {
            return redirect()->route('mod_menu.admin.list_menu')->with('flash_data', ['type' => 'warning', 'message' => 'Không tìm thấy menu']);
        }
        if (config($data['item']['module'] . '.menu')) {
            $data['listMItem'] = config($data['item']['module'] . '.menu');
        }
        return view('Menu::admin.item.edit', $data);
    }

    public function postEditItem($id, Request $request)
    {

        $request->validate([
            'title' => 'required|max:255',
            'link' => 'required|max:255',
            'long_title' => 'max:255'
        ], [
            'title.required' => 'Chưa nhập tên mục',
            'title.max' => 'Tên mục không vượt quá 255 ký tự',
            'link.required' => 'Chưa nhập đường dẫn liên kết',
            'link.max' => 'Đường dẫn liên kết không được vượt quá 255 ký tự',
            'long_title.max' => 'Tiêu đề dài không được vượt quá 255 ký tự'
        ]);

        Menuitem::where('id', $id)->update([
            'title' => $request->title,
            'link' => $request->link,
            'parent_id' => $request->parent_id,
            'module' => (!empty($request->module) && !empty($request->item)) ? $request->module : null,
            'target' => $request->target,
            'long_title' => $request->long_title,
            'content' => $request->content
        ]);

        $item = Menuitem::find($id);
        // dd($item->parent_id);
        if ($item->parent_id) {
            return redirect()->route('mod_menu.admin.list_menu_item', $item['parent_id'])->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
        }
        return redirect()->route('mod_menu.admin.list_menu_item', $item['menu_id'])->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    public function getDeleteItem($id)
    {
        Menuitem::where('parent_id', $id)->orWhere('id', $id)->delete();
        mod_menu_fix_order();
        return redirect()->back()->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    public function ajaxChangeOderMenuItem(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        $listMenuItem = Menuitem::where([['id', '!=', $id]])->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listMenuItem as $iMenuItem) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Menuitem::where('id', $iMenuItem['id'])->update(['order' => $weight]);
        }
        Menuitem::where('id', $id)->update(['order' => $order]);
        mod_menu_fix_order_item();
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function ajaxChangeStatus(Request $request)
    {
        try {
            Menuitem::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    public function ajaxLoadListItem(Request $request)
    {
        return response()->json(config($request->module . '::menu'));
    }
}