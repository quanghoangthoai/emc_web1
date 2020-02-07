<?php

namespace Modules\Slider\Controllers;

use Illuminate\Http\Request;
use Modules\Slider\Models\Block;
use Modules\Slider\Models\Slide;
use System\Core\Controllers\AdminController as SystemAdminController;

class AdminController extends SystemAdminController
{
    public function getList()
    {
        $data['listSlide'] =  Slide::orderBy('id', 'asc')->get();
        $data['minOrder'] = Slide::min('order');
        $data['maxOrder'] = Slide::max('order');
        return view('Slider::admin.slide.list', $data);
    }
    public function getAddSlide()
    {
        if (Block::count() == 0) {
            return redirect()->route('mod_block.admin.add_block')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng thêm khối trước']);
        }
        $data['listBlock'] = mod_slider_block();
        return view('Slider::admin.slide.add', $data);
    }
    public function postAddSlide(Request $request)
    {

        $request->validate([
            'title' => 'required|max:255',
            'button_text' => 'required|max:255',
            'description' => 'max:255',
            'link' => 'required|max:255',
            'block_id' => 'required',
            'image' => 'required',
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'title.max' => 'Tiêu đề không vượt quá 255 ký tự',
            'button_text.required' => 'Chưa nhập nội dung button',
            'button_text.max' => 'Button không vượt quá 255 ký tự',
            'link.required' => 'Chưa nhập đường dẫn URL',
            'link.max' => 'Đường dẫn không vượt quá 255 ký tự',
            'description.max' => 'Nội dung không vượt quá 255 ký tự',
            'block_id.required' => 'Chưa chọn khối ',
            'image.required' => 'Chưa chọn hình ảnh ',
        ]);
        $maxOrder = Slide::max('order');
        Slide::create([
            'title' => $request->title,
            'link' => $request->link,
            'image' => $request->image,
            'description' => $request->description,
            'block_id' => $request->block_id,
            'status' => $request->status,
            'button_text' => $request->button_text,
            'order' => $maxOrder ? $maxOrder + 1 : 1
        ]);
        return redirect()->route('mod_slide.admin.list_slide')->with('flash_data', ['type' => 'success', 'message' => 'Thêm slide thành công']);
    }
    public function getEditSlide($id)
    {
        $data['slide'] = Slide::find($id);
        // dd(mod_slider_block($id));
        $data['listBlock'] = mod_slider_block();
        return view('Slider::admin.slide.edit', $data);
    }
    public function postEditSlide(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'button_text' => 'required|max:255',
            'description' => 'max:255',
            'link' => 'required|max:255',
            'block_id' => 'required',
            'image' => 'required',
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'title.max' => 'Tiêu đề không vượt quá 255 ký tự',
            'button_text.required' => 'Chưa nhập nội dung button',
            'button_text.max' => 'Button không vượt quá 255 ký tự',
            'link.required' => 'Chưa nhập đường dẫn URL',
            'link.max' => 'Đường dẫn không vượt quá 255 ký tự',
            'description.max' => 'Nội dung không vượt quá 255 ký tự',
            'block_id.required' => 'Chưa chọn khối ',
            'image.required' => 'Chưa chọn hình ảnh ',
        ]);
        Slide::where('id', $id)->update([
            'title' => $request->title,
            'link' => $request->link,
            'image' => $request->image,
            'block_id' => $request->block_id,
            'description' => $request->description,
            'status' => $request->status,
            'button_text' => $request->button_text,
        ]);
        return redirect()->route('mod_slide.admin.list_slide')->with('flash_data', ['type' => 'success', 'message' => 'Sửa slide thành công']);
    }

    public function getDeleteSlide($id)
    {
        Slide::where('id', $id)->delete();
        return redirect()->route('mod_slide.admin.list_slide')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    public function ajaxChangeOrderSlide(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        $listSlide = Slide::where([['id', '!=', $id]])->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listSlide as $iSlide) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Slide::where('id', $iSlide['id'])->update(['order' => $weight]);
        }
        Slide::where('id', $id)->update(['order' => $order]);
        mod_slider_fix_oder();
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }
    public function ajaxChangeStatus(Request $request)
    {
        try {
            Slide::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    public function getListBlock()
    {
        $data['listBlock'] =  Block::orderBy('id', 'asc')->get();
        return view('Slider::admin.block.list', $data);
    }
    public function getAddBlock()
    {
        $data['listBlock'] = mod_slider_block();

        return view('Slider::admin.block.add', $data);
    }
    public function postAddBlock(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ], [
            'name.required' => 'Chưa nhập tên khối',
            'name.max' => 'Tên khối không quá 255 ký tự',
            'description.max' => 'Mô tả ngắn không quá 255 ký tự'
        ]);
        Block::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->route('mod_block.admin.list_block')->with('flash_data', ['type' => 'success', 'message' => 'Thêm khối thành công']);
    }
    public function getEditBlock(Request $request, $id)
    {
        $data['block'] = Block::find($id);
        return view('Slider::admin.block.edit', $data);
    }
    public function postEditBlock(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ], [
            'name.required' => 'Chưa nhập tên khối',
            'name.max' => 'Tên khối không quá 255 ký tự',
            'description.max' => 'Mô tả ngắn không quá 255 ký tự'
        ]);
        Block::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->route('mod_block.admin.list_block')->with('flash_data', ['type' => 'success', 'message' => 'Thêm khối thành công']);
    }
    public function getDeleteBlock($id)
    {
        Block::where('id', $id)->delete();
        return redirect()->route('mod_block.admin.list_block')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    public function ajaxChangeStatusBlock(Request $request)
    {
        try {
            Block::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }
}