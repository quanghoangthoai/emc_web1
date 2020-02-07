<?php

namespace Modules\Comment\Controllers;

use Illuminate\Http\Request;
use System\Core\Controllers\AdminController as SystemAdminController;
use Modules\Comment\Models\CommentModule;
use Modules\Comment\Models\Comment;
use System\Core\Models\Module;

class AdminController extends SystemAdminController
{
    // Module
    public function getList()
    {
        $data['listModule'] = CommentModule::all();
        $data['module'] = Module::where('status', 1)->get();
        return view('Comment::admin.module.list', $data);
    }

    public function postAddModule(Request $request)
    {
        $request->validate(
            [
                'module' => 'required|unique:comments_modules,name'
            ],
            [
                'module.required' => 'Chưa chọn module',
                'module.unique' => 'Tên module đã tồn tại'
            ]
        );
        $data = Comment::where('commentable_type', $request->module)->first();
        if (isset($data)) {
            CommentModule::insert([
                'id' => $data['module_id'],
                'name' => $request->module
            ]);
            return redirect()->route('mod_comment.admin.list')->with('flash_data', ['type' => 'success', 'message' => 'Thêm thành công']);
        } else {
            CommentModule::insert([
                'name' => $request->module
            ]);
            return redirect()->route('mod_comment.admin.list')->with('flash_data', ['type' => 'success', 'message' => 'Thêm thành công']);
        }
    }

    public function geDeleteModule($id)
    {
        CommentModule::where('id', $id)->delete();
        return redirect()->route('mod_comment.admin.list')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
    }

    public function changeStatusCommentModule(Request $request)
    {
        try {
            CommentModule::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }

    // Comment
    public function getListComment(Request $request)
    {
        $param = $request->all();
        $filterdata = Comment::filter($param);
        $data['listCommment'] = $filterdata->orderBy('id', 'desc')->paginate(5)->appends(request()->except('page'));
        if (isset($param['created_at'])) {
            $arr_time = explode(" - ", $param['created_at']);
            $param['begindate'] = $arr_time[0];
            $param['enddate'] = $arr_time[1];
        }
        $data['filterdata'] = $param;
        return view('Comment::admin.comment.list', $data);
    }

    public function geDeleteComment($id)
    {
        Comment::where('id', $id)->delete();
        Comment::where('parent_id', $id)->delete();
        return redirect()->route('mod_comment.admin.list_comment')->with('flash_data', ['type' => 'success', 'message' => 'Xóa thành công']);
    }
}
