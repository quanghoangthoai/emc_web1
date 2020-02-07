<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use System\Admin\Models\Widget;
use System\Core\Controllers\AdminController;
use System\Core\Models\Module;

class WidgetController extends AdminController
{
    /**
     * list
     */
    public function getList()
    {
        global $active_modules;
        $data['page_title'] = 'Quản lý widget';
        $listGroup = config('widget.groups');
        $arrWidget = [];
        foreach ($listGroup as $group) {
            $widgets = Widget::where('group', $group['name'])->orderBy('order', 'asc')->get();
            if ($widgets) {
                $minOrder = Widget::where('group', $group['name'])->min('order');
                $maxOrder = Widget::where('group', $group['name'])->max('order');
                foreach ($widgets as $widget) {
                    $widget['minOrder'] = $minOrder;
                    $widget['maxOrder'] = $maxOrder;
                    $arrWidget[$group['name']][] = $widget;
                }
            }
        }
        $data['listWidget'] = $arrWidget;
        $data['listGroup'] = $listGroup;
        // get all widget from modules
        $listActiveWidget = [];
        foreach ($active_modules as $mod) {
            $webWidgets = config($mod . '::widget.web');
            if ($webWidgets) {
                $mod = Module::where('name', $mod)->first();
                foreach ($webWidgets as $webWidget) {
                    $webWidget['module'] = $mod['name'];
                    $webWidget['module_title'] = $mod['title'];
                    $listActiveWidget[] = $webWidget;
                }
            }
        }
        $data['listActiveWidget'] = $listActiveWidget;
        return view('Admin::widget.list', $data);
    }

    /**
     * add
     */
    public function getAdd()
    {
        $data['page_title'] = 'Thêm widget';
        return view('Admin::widget.add', $data);
    }

    /**
     * post add
     */
    public function postAdd(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'name.required' => 'Chưa chọn widget'
        ]);

        $maxOrder = Widget::where('group', $request->position)->max('order');
        Widget::create([
            'module' => $request->module,
            'name' => $request->name,
            'title' => $request->title,
            'link' => $request->link,
            'template' => $request->template,
            'position' => $request->position,
            'config' => $request->has('config') ? json_encode($request->config) : json_encode([]),
            'active' => $request->has('active') ? 1 : 0,
            'order' => $maxOrder ? $maxOrder + 1 : 1
        ]);
        cms_fix_widget_order();

        return redirect()->route('admin.widget.list')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm dữ liệu']);
    }

    /**
     * edit
     */
    public function getEdit($id)
    {
        $data['widget'] = Widget::find($id);
        $data['listWidget'] = get_widgets_module($data['widget']['module']);
        $data['arrConfig'] = json_decode($data['widget']['config'], true);
        return view('Dashboard::widget.edit', $data);
    }

    /**
     * post edit
     */
    public function postEdit($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'name.required' => 'Chưa chọn widget'
        ]);

        Widget::where('id', $id)->update([
            'module' => $request->module,
            'name' => $request->name,
            'title' => $request->title,
            'link' => $request->link,
            'template' => $request->template,
            'position' => $request->position,
            'config' => $request->has('config') ? json_encode($request->config) : json_encode([]),
            'active' => $request->has('active') ? 1 : 0
        ]);
        cms_fix_widget_order();

        return redirect()->route('admin.widget.list')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    /**
     * delete
     */
    public function getDelete($id)
    {
        Widget::where('id', $id)->delete();
        cms_fix_widget_order();
        return redirect()->route('admin.widget.list')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    /**
     * ajaxLoadWidgetModule
     */
    public function ajaxLoadWidgetModule(Request $request)
    {
        return response()->json(get_widgets_module($request->module));
    }

    /**
     * ajaxLoadConfigWidget
     */
    public function ajaxLoadConfigWidget(Request $request)
    {
        $arrConfig = json_decode($request->config, true);
        $html = call_user_func_array(['Modules\\' . $request->module . '\Widgets\\' . $request->widget, 'config_view'], [$arrConfig]);
        return response()->json($html);
    }

    function ajaxLoadAddWidget(Request $request)
    {
        try {
            $widget = config($request->module . '::widget.web.' . $request->widget);
            $data['widget'] = $widget;
            $data['group'] = config('widget.groups.' . $request->group);
            $data['module'] = Module::where('name', $request->module)->first();
            return response()->json(['status' => true, 'html' => view('Admin::widget.formAddWidget', $data)->render()]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.']);
        }
    }

    public function ajaxLoadWidgetToGroup()
    {
        try {
            $listGroup = config('widget.groups');
            $htmlGroup = [];
            foreach ($listGroup as $group) {
                $listWidget = Widget::where('group', $group['name'])->orderBy('order', 'asc')->get();
                $htmlGroup[$group['name']] = view('Admin::widget.listWidgetInGroup', compact('listWidget'))->render();
            }
            return response()->json(['status' => true, 'html' => $htmlGroup]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng tải lại trang.']);
        }
    }

    public function ajaxSubmitAddWidget(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'module' => 'required',
            'name' => 'required',
            'group' => 'required',
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'module.required' => 'Chưa nhập module',
            'name.required' => 'Chưa nhập tên',
            'group.required' => 'Chưa nhập vị trí',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        try {
            $maxOrder = Widget::where('group', $request->group)->max('order');
            Widget::create([
                'module' => $request->module,
                'name' => $request->name,
                'title' => $request->title,
                'group' => $request->group,
                'config' => $request->has('config') ? json_encode($request->config) : json_encode([]),
                'status' => 1,
                'order' => $maxOrder ? $maxOrder + 1 : 1
            ]);
            return response()->json(['status' => true, 'message' => 'Thêm widget thành công']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.']);
        }
    }

    public function ajaxSubmitUpdateWidget(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
        }

        try {
            Widget::where('id', $request->id)->update([
                'title' => $request->title,
                'config' => $request->has('config') ? json_encode($request->config) : json_encode([]),
            ]);
            return response()->json(['status' => true, 'message' => 'Cập nhật widget thành công']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.']);
        }
    }

    public function ajaxSubmitDeleteWidget(Request $request)
    {
        try {
            Widget::where('id', $request->id)->delete();
            return response()->json(['status' => true, 'message' => 'Xóa widget thành công']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.']);
        }
    }

    public function ajaxUpdatePositionWidget(Request $request)
    {
        try {
            $from_group = $request->from_group;
            $to_group = $request->to_group;
            $widget_id = $request->widget_id;
            $arr_source = $request->arr_source;
            $arr_target = $request->arr_target;
            if ($from_group != $to_group) {
                Widget::where('id', $widget_id)->update(['group' => $to_group]);

                if ($arr_source) {
                    $order = 1;
                    foreach ($arr_source as $idW) {
                        Widget::where('id', $idW)->update(['order' => $order]);
                        $order++;
                    }
                }
                if ($arr_target) {
                    $order = 1;
                    foreach ($arr_target as $idW) {
                        Widget::where('id', $idW)->update(['order' => $order]);
                        $order++;
                    }
                }
            } else {
                if ($arr_target) {
                    $order = 1;
                    foreach ($arr_target as $idW) {
                        Widget::where('id', $idW)->update(['order' => $order]);
                        $order++;
                    }
                }
            }
            return response()->json(['status' => true, 'message' => 'Đã cập nhật vị trí widget']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.']);
        }
    }
}