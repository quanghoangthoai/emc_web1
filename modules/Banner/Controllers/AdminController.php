<?php

namespace Modules\Banner\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Load model
use Modules\Banner\Models\Block;
use Modules\Banner\Models\Banner;

class AdminController extends Controller
{
    /**
     * list all banner
     */
    public function getListAllBanner()
    {
        $data['listBanner'] =  Banner::all();
        return view('Banner::admin.banner.listall', $data);
    }

    /**
     * add banner
     */
    public function getAddBanner()
    {
        if (Block::count() == 0) {
            return redirect()->route('mod_banner.admin.addblock')->with('flash_data', ['type' => 'warning', 'message' => 'Vui lòng thêm khối trước']);
        }
        return view('Banner::admin.banner.add');
    }

    /**
     * post add banner
     */
    public function postAddBanner(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'block_id' => 'required',
            'file_src' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'block_id.required' => 'Chưa chọn khối',
            'file_src.required' => 'Chưa chọn file'
        ]);

        // Xử lý ngày bắt đầu
        if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $request->begin_date, $m)) {
            $begin_time = mktime($request->begin_hour, $request->begin_minute, 0, $m[2], $m[1], $m[3]);
        } else {
            $begin_time = time();
        }
        $begin_time = date('Y-m-d H:i:s', $begin_time);
        // Xứ lý ngày kết thúc
        if (!empty($request->expired_date)) {
            if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $request->expired_date, $m)) {
                $expired_time = mktime($request->expired_hour, $request->expired_minute, 0, $m[2], $m[1], $m[3]);
                $expired_time = date('Y-m-d H:i:s', $expired_time);
            } else {
                $expired_time = null;
            }
        } else {
            $expired_time = null;
        }

        Banner::create([
            'block_id' => $request->block_id,
            'title' => $request->title,
            'file_src' => $request->file_src,
            'file_alt' => $request->file_alt,
            'link' => $request->link,
            'target' => $request->target,
            'begin_time' => $begin_time,
            'expired_time' => $expired_time,
            'description' => $request->description
        ]);

        return redirect()->route('mod_banner.admin.listallbanner')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm dữ liệu']);
    }

    /**
     * edit banner
     */
    public function getEditBanner($id)
    {
        $data['banner'] = Banner::find($id);
        return view('Banner::admin.banner.edit', $data);
    }

    /**
     * post edit banner
     */
    public function postEditBanner($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'block_id' => 'required',
            'file_src' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'block_id.required' => 'Chưa chọn khối',
            'file_src.required' => 'Chưa chọn file'
        ]);

        // Xử lý ngày bắt đầu
        if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $request->begin_date, $m)) {
            $begin_time = mktime($request->begin_hour, $request->begin_minute, 0, $m[2], $m[1], $m[3]);
        } else {
            $begin_time = time();
        }
        $begin_time = date('Y-m-d H:i:s', $begin_time);
        // Xứ lý ngày kết thúc
        if (!empty($request->expired_date)) {
            if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $request->expired_date, $m)) {
                $expired_time = mktime($request->expired_hour, $request->expired_minute, 0, $m[2], $m[1], $m[3]);
                $expired_time = date('Y-m-d H:i:s', $expired_time);
            } else {
                $expired_time = null;
            }
        } else {
            $expired_time = null;
        }

        Banner::where('id', $id)->update([
            'block_id' => $request->block_id,
            'title' => $request->title,
            'file_src' => $request->file_src,
            'file_alt' => $request->file_alt,
            'link' => $request->link,
            'target' => $request->target,
            'begin_time' => $begin_time,
            'expired_time' => $expired_time,
            'description' => $request->description
        ]);

        return redirect()->route('mod_banner.admin.listallbanner')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    /**
     * delete banner
     */
    public function getDeleteBanner($id)
    {
        Banner::where('id', $id)->delete();

        return redirect()->route('mod_banner.admin.listallbanner')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }

    /**
     * getListBlock
     */
    public function getListBlock()
    {
        $data['listBlock'] = Block::all();
        return view('Banner::admin.block.list', $data);
    }

    /**
     * getAddBlock
     */
    public function getAddBlock()
    {
        return view('Banner::admin.block.add');
    }

    /**
     * postAddBlock
     */
    public function postAddBlock(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'width' => 'required',
            'height' => 'required',
            'form' => 'required',
            'type' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'width.required' => 'Chưa nhập chiều rộng',
            'height.required' => 'Chưa nhập chiều cao',
            'form.required' => 'Chưa chọn kiểu hiển thị',
            'type.required' => 'Chưa chọn loại quảng cáo'
        ]);

        // dd($request->all());
        Block::create($request->except('_token'));

        return redirect()->route('mod_banner.admin.listblock')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm dữ liệu']);
    }

    /**
     * getEditBlock
     */
    public function getEditBlock($id)
    {
        $data['block'] = Block::find($id);
        return view('Banner::admin.block.edit', $data);
    }

    /**
     * postEditBlock
     */
    public function postEditBlock($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'width' => 'required',
            'height' => 'required',
            'form' => 'required',
            'type' => 'required'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'width.required' => 'Chưa nhập chiều rộng',
            'height.required' => 'Chưa nhập chiều cao',
            'form.required' => 'Chưa chọn kiểu hiển thị',
            'type.required' => 'Chưa chọn loại quảng cáo'
        ]);

        // dd($request->all());
        Block::where('id', $id)->update($request->except('_token'));

        return redirect()->route('mod_banner.admin.listblock')->with('flash_data', ['type' => 'success', 'message' => 'Đã cập nhật dữ liệu']);
    }

    /**
     * delete block
     */
    public function getDeleteBlock($id)
    {
        Banner::where('block_id', $id)->delete();
        Block::where('id', $id)->delete();

        return redirect()->route('mod_banner.admin.listblock')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa dữ liệu']);
    }
}
