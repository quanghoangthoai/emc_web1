<?php

namespace Modules\Product\Controllers;

use Modules\Product\Models\Category;
use Illuminate\Http\Request;
use Modules\Product\Models\Product;
use System\Core\Controllers\AdminController as SystemAdminController;

class AdminController extends SystemAdminController
{
    /**
     * List Categories Product
     */
    public function getListCategory(Request $request)
    {
        $data['listCategory'] = mod_product_list_category();
        return view('Product::admin.category.list', $data);
    }
    /**
     * POST Add Category
     */
    public function postAddCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'Chưa nhập tên danh mục',
            'image.required' => 'Chưa chọn hình ảnh',
        ]);

        $new_category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        $new_category->fill(['order' => $new_category['id']])->save();

        return redirect()->route('mod_product.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Thêm danh mục thành công']);
    }

    /**
     * GET Edit Category
     */
    public function getEditCategory($id)
    {
        $data['category_edit'] = Category::find($id);
        if ($data['category_edit']) {
            $data['listCategory'] = mod_product_list_category();
            return view('Product::admin.category.edit', $data);
        }

        return redirect()->route('mod_product.admin.list_category')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy danh mục để sửa']);
    }

    /**
     * Post Edit Category
     */
    public function postEditCategory($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'Chưa nhập tên danh mục',
            'image.required' => 'Chưa chọn hình ảnh',
        ]);

        Category::where('id', $id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('mod_product.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật danh mục thành công']);
    }

    /**
     * GET Delete category
     */
    public function getDeleteCategory($id)
    {
        mod_product_delete_category($id);
        return redirect()->route('mod_product.admin.list_category')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa danh mục và tất cả dữ liệu liên quan']);
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


    /**
     * Get Post Product
     */
    public function getListProduct()
    {
        $data['listPost'] = Product::orderBy('id', 'desc')->get();
        return view('Product::admin.product.list', $data);
    }
    /**
     * Get Add Product
     */
    public function getAddProduct()
    {
        if (Category::count() == 0) {
            return redirect()->route('mod_product.admin.list_category')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng thêm danh mục trước']);
        }
        $data['listCategory'] = mod_product_list_category();
        return view('Product::admin.product.add', $data);
    }

    /**
     * Post Add Product
     */
    public function postAddProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên sản phẩm',
            'price.required' => 'Chưa nhập giá niêm yết',
            'price.numeric' => 'Giá niêm yết không hợp lệ',
            'category_id.required' => 'Vui lòng chọn danh mục',

        ]);

        $sale_begintime = null;
        $sale_endtime = null;

        if ($request->has('enable_sale')) {
            $request->validate([
                'sale_time' => 'required',
                'sale_price' => 'required|numeric',
            ], [
                'sale_time.required' => 'Chưa chọn thời gian khuyến mãi',
                'sale_price.required' => 'Chưa nhập giá khuyến mãi',
                'sale_price.numeric' => 'Giá khuyến mãi không hợp lệ',
            ]);
        }

        if ($request->sale_time) {
            $arr_time = explode(" - ", $request->sale_time);
            $sale_begintime = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $arr_time[0])->format('Y-m-d H:i:s');
            $sale_endtime = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $arr_time[1])->format('Y-m-d H:i:s');
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'featured' => $request->has('featured') ? 1 : 0,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'price' => $request->price,
            'unit_type' => $request->unit_type,
            'display_price' => $request->display_price,
            'enable_sale' => $request->has('enable_sale') ? 1 : 0,
            'sale_price' => $request->sale_price,
            'sale_begintime' => $sale_begintime,
            'sale_endtime' => $sale_endtime,
            'status' => $request->status,
        ]);

        return redirect()->route('mod_product.admin.list_product')->with('flash_data', ['type' => 'success', 'message' => 'Thêm sản phẩm thành công']);
    }

    /**
     * Get Edit Product
     */
    public function getEditProduct($id)
    {
        $data['product'] = Product::where('id', $id)->first();
        if ($data['product']) {
            if ($data['product']['enable_sale'])
                $data['product']['sale_time'] = date('d/m/Y H:i', strtotime($data['product']['sale_begintime'])) . ' - ' . date('d/m/Y H:i', strtotime($data['product']['sale_endtime']));
            else $data['product']['sale_time'] = '';
            $data['listCategory'] = mod_product_list_category();
            return view('Product::admin.product.edit', $data);
        }
        return redirect()->route('mod_product.admin.list')->with('flash_data', ['type' => 'success', 'message' => 'Không tìm thấy sản phẩm.']);
    }

    /**
     * Post Edit Product
     */
    public function postEditProduct($id, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên sản phẩm',
            'price.required' => 'Chưa nhập giá niêm yết',
            'price.numeric' => 'Giá niêm yết không hợp lệ',
            'category_id.required' => 'Vui lòng chọn danh mục',

        ]);

        $sale_begintime = null;
        $sale_endtime = null;

        if ($request->has('enable_sale')) {
            $request->validate([
                'sale_time' => 'required',
                'sale_price' => 'required|numeric',
            ], [
                'sale_time.required' => 'Chưa chọn thời gian khuyến mãi',
                'sale_price.required' => 'Chưa nhập giá khuyến mãi',
                'sale_price.numeric' => 'Giá khuyến mãi không hợp lệ',
            ]);
        }

        if ($request->sale_time) {
            $arr_time = explode(" - ", $request->sale_time);
            $sale_begintime = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $arr_time[0])->format('Y-m-d H:i:s');
            $sale_endtime = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $arr_time[1])->format('Y-m-d H:i:s');
        }

        Product::where('id', $id)->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'featured' => $request->has('featured') ? 1 : 0,
            'image' => $request->image,
            'description' => $request->description,
            'content' => $request->content,
            'price' => $request->price,
            'unit_type' => $request->unit_type,
            'display_price' => $request->display_price,
            'enable_sale' => $request->has('enable_sale') ? 1 : 0,
            'sale_price' => $request->sale_price,
            'sale_begintime' => $sale_begintime,
            'sale_endtime' => $sale_endtime,
            'status' => $request->status,
        ]);

        return redirect()->route('mod_product.admin.list_product')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    /**
     * Delete Product
     */

    public function getDeleteProduct($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('mod_product.admin.list_product')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa sản phẩm']);
    }
    /**
     * Ajax Change Status
     */

    public function ajaxChangeStatus(Request $request)
    {
        try {
            Product::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    public function ajaxModalInsertContent()
    {
        try {
            $data['listCategory'] = mod_product_list_category();
            $listProduct = [];
            foreach ($data['listCategory'] as $cat) {
                $category = Category::find($cat['id']);
                $listProduct[$cat['id']] = $category->products;
            }
            $data['listProduct'] = $listProduct;
            return response()->json(view('Product::admin.modalInsertContent', $data)->render());
        } catch (\Throwable $th) {
            return response()->json('<div class="alert alert-danger">Đã có lỗi xảy ra. Vui lòng đóng và thử lại.</div>');
        }
    }
}