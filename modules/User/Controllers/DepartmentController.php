<?php

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use Modules\User\Models\Department;
use System\Core\Controllers\AdminController as SystemAdminController;

class DepartmentController extends SystemAdminController
{
    public function getListDepartment()
    {
        $data['listDepartment'] = Department::orderBy('name', 'asc')->get();
        return view('User::admin.department.list', $data);
    }

    public function getEditDepartment($id)
    {
        $data['listDepartment'] = Department::orderBy('name', 'asc')->get();
        $data['editdepartment'] = Department::find($id);
        return view('User::admin.department.edit', $data);
    }

    public function getDeleteDepartment($id)
    {
        Department::where('id', $id)->delete();
        return redirect()->route('mod_user.admin.list_department')->with('flash_data', ['type' => 'success', 'message' => 'Đã xóa phòng ban']);
    }

    public function postAddDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên phòng ban'
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return redirect()->route('mod_user.admin.list_department')->with('flash_data', ['type' => 'success', 'message' => 'Thêm phòng ban thành công']);
    }

    public function postEditDepartment($id, Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Chưa nhập tên phòng ban'
        ]);

        Department::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return redirect()->route('mod_user.admin.list_department')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật phòng ban thành công']);
    }
}