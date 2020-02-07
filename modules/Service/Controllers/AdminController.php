<?php

namespace Modules\Service\Controllers;

use Illuminate\Http\Request;
use System\Core\Controllers\AdminController as SystemAdminController;
use Modules\Service\Models\Service;
use Modules\Service\Models\Category;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Classes\C3\Chart;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminController extends SystemAdminController
{
    // Service
    public function getListService(Request $request)
    {
        $param = $request->all();
        $filterdata = Service::filter($param);
        $data['listService'] = $filterdata->orderBy('order', 'asc')->paginate(5)->appends(request()->except('page'));
        $data['filterdata'] = $param;
        return view('Service::admin.service.list', $data);
    }

    public function getAddService()
    {
        if (Category::count() == 0)
            return redirect()->route('mod_service.admin.list_category')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng thêm danh mục trước']);

        $data['listCategory'] = mod_service_list_category();
        return view('Service::admin.service.add', $data);
    }

    public function postAddService(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:services,slug',
                'category_id' => 'required',
                'content' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập tên dịch vụ',
                'slug.required' => 'Chưa nhập liên kết tĩnh',
                'slug.unique' => 'Liên kết tĩnh bị trùng',
                'category_id.required' => 'Chưa chọn danh mục',
                'content.required' => 'Chưa nhập nội dung chi tiết'
            ]
        );

        $new_service = Service::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'image' => $request->image,
            'featured' => $request->has('featured') ? 1 : 0,
            'description' => $request->description,
            'content' => $request->content,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
        ]);

        $new_service->fill(['order' => $new_service['id']])->save();

        return redirect()->route('mod_service.admin.list_service')->with('flash_data', ['type' => 'success', 'message' => 'Thêm dịch vụ thành công']);
    }

    public function getDeleteService($id)
    {
        Service::where('id', $id)->delete();
        return redirect()->route('mod_service.admin.list_service')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dịch vụ']);
    }

    public function getEditService($id)
    {
        $data['service'] = Service::where('id', $id)->first();
        if ($data['service']) {
            $data['listCategory'] = mod_service_list_category();
            return view('Service::admin.service.edit', $data);
        }
        return redirect()->route('mod_service.admin.list_services')->with('flash_data', ['type' => 'success', 'message' => 'Không tìm thấy dịch vụ.']);
    }

    public function postEditService($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:services,slug,' . $id,
                'category_id' => 'required',
                'content' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập tên dịch vụ',
                'slug.required' => 'Chưa nhập liên kết tĩnh',
                'slug.unique' => 'Liên kết tĩnh bị trùng',
                'category_id.required' => 'Chưa chọn danh mục',
                'content.required' => 'Chưa nhập nội dung chi tiết'
            ]
        );

        Service::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'image' => $request->image,
            'featured' => $request->has('featured') ? 1 : 0,
            'description' => $request->description,
            'content' => $request->content,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
        ]);

        return redirect()->route('mod_service.admin.list_service')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật dịch vụ thành công']);
    }

    public function ajaxChangeOrderService(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        Service::where('id', $id)->update(['order' => $order]);
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function changeStatusService(Request $request)
    {
        try {
            Service::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    // Service Category


    public function getListCategory()
    {
        $data['listCategory'] = mod_service_list_category();
        return view('Service::admin.category.list', $data);
    }

    public function postAddCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:service_categories,slug',
        ], [
            'name.required' => 'Chưa nhập tên danh mục',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
        ]);

        $new_category = Category::create([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,

        ]);

        $new_category->fill(['order' => $new_category['id']])->save();

        return redirect()->route('mod_service.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm danh mục']);
    }

    public function getDeleteCategory($id)
    {
        mod_service_delete_category($id);
        return redirect()->route('mod_service.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
    }

    public function getEditCategory($id)
    {
        $data['category_edit'] = Category::where('id', $id)->first();
        if ($data['category_edit']) {
            $data['listCategory'] = mod_service_list_category();
            return view('Service::admin.category.edit', $data);
        }
        return redirect()->route('mod_service.admin.list_category')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy danh mục']);
    }

    public function postEditCategory($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:service_categories,slug,' . $id,
        ], [
            'name.required' => 'Chưa nhập tên danh mục',
            'slug.required' => 'Chưa nhập liên kết tĩnh',
            'slug.unique' => 'Liên kết tĩnh bị trùng',
        ]);

        Category::where('id', $id)->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_image' => $request->seo_image,
            'seo_keywords' => $request->seo_keywords,
        ]);

        return redirect()->route('mod_service.admin.list_category')->with(['flash_data' => ['type' => 'success', 'message' => 'Cập nhật thành công']]);
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

    public function changeStatusCategory(Request $request)
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
    public function index()
    {
        $chart_options = [
            'chart_title' => 'Dịch vụ ',
            'report_type' => 'group_by_date',
            'model' => 'Modules\Service\Models\Service',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 30, // show only last 30 days
        ];
        $chart1 = new LaravelChart($chart_options);
        return view('Service::widgets.chart', compact('chart1'));
    }
}
