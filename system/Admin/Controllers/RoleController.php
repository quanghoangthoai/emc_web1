<?php

namespace System\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use System\Core\Controllers\AdminController;
use System\Core\Models\Role;

class RoleController extends AdminController
{
    public function getListRole()
    {
        $data['listRole'] = Role::orderBy('order', 'asc')->get();
        $data['minOrder'] = Role::min('order');
        $data['maxOrder'] = Role::max('order');
        return view('Admin::role.list', $data);
    }

    public function getAddRole()
    {
        sync_all_permissions();
        // dd(get_list_permissions());
        return view('Admin::role.add');
    }

    public function postAddRole(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:roles,title',
            'name' => 'required|unique:roles,name'
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'title.unique' => 'Tiêu đề đã tồn tại',
            'name.required' => 'Chưa nhập mã vai trò',
            'name.unique' => 'Mã vai trò đã tồn tại'
        ]);

        $role = Role::create([
            'title' => $request->title,
            'name' => $request->name,
            'description' => $request->description,
            'order' => Role::max('order') + 1
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('cms.admin.list_role')->with('flash_data', ['type' => 'success', 'message' => 'Thêm dữ liệu thành công']);
    }

    public function getEditRole($id)
    {
        $role = Role::find($id);
        $role['arr_permissions'] = $role->getPermissionNames()->toArray();
        $data['role'] = $role;
        return view('Admin::role.edit', $data);
    }

    public function postEditRole($id, Request $request)
    {
        $request->validate([
            'title' => 'required|unique:roles,title,' . $id,
            'name' => 'required|unique:roles,name,' . $id
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'title.unique' => 'Tiêu đề đã tồn tại',
            'name.required' => 'Chưa nhập name_slug',
            'name.unique' => 'name_slug đã tồn tại'
        ]);
        Role::where('id', $id)->update([
            'title' => $request->title,
            'name' => $request->name,
            'description' => $request->description
        ]);
        $role = Role::findById($id);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('cms.admin.list_role')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật dữ liệu thành công']);
    }

    public function getDeleteRole($id)
    {
        $role = Role::find($id);
        $role->syncPermissions(null);
        $role->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('cms.admin.list_role')->with('flash_data', ['type' => 'success', 'message' => 'Xóa dữ liệu thành công']);
    }

    public function ajaxChangeOrdeRole(Request $request)
    {
        $id = $request->id;
        $order = $request->order;
        $listRole = Role::where([['id', '!=', $id]])->orderBy('order', 'asc')->get(['id']);
        $weight = 0;
        foreach ($listRole as $role) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Role::where('id', $role['id'])->update(['order' => $weight]);
        }
        Role::where('id', $id)->update(['order' => $order]);
        role_fix_order();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công'
        ]);
    }
}