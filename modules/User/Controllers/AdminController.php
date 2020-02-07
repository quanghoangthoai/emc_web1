<?php

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use Modules\User\Models\Department;
use Modules\User\Models\User;
use System\Core\Controllers\AdminController as SystemAdminController;
use System\Core\Models\Role;
use Hash;
use Illuminate\Support\Facades\Mail;
use Modules\User\Models\Userinfo;

class AdminController extends SystemAdminController
{
    function __construct()
    {
        check_add_superadmin();
    }

    public function getListUser()
    {
        $data['listUser'] = User::all();
        return view('User::admin.user.list', $data);
    }

    public function getAddUser()
    {
        $data['page_title'] = 'Thêm tài khoản';
        $data['listRole'] = Role::where('name', '<>', 'superadmin')->orderBy('order', 'asc')->get();
        $listRoleWithPermissions = [];
        foreach ($data['listRole'] as $iRole) {
            foreach ($iRole->permissions as $iPermission) {
                $listRoleWithPermissions[$iRole['id']][] = $iPermission['id'];
            }
        }
        $data['listRoleWithPermissions'] = json_encode($listRoleWithPermissions);
        $data['listDepartment'] = Department::orderBy('name', 'asc')->get();
        return view('User::admin.user.add', $data);
    }

    /**
     * post add user
     */
    public function postAddUser(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'repassword' => 'required|same:password'
        ], [
            'email.required' => 'Chưa nhập email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Chưa nhập mật khẩu',
            'repassword.required' => 'Chưa nhập lại mật khẩu',
            'repassword.same' => 'Hai mật khẩu không khớp'
        ]);

        // execute add to db
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'display_name' => $request->display_name ? $request->display_name : $request->email,
            'status' => $request->status,
        ]);

        $new_user_info = $request->info;
        $new_user_info['user_id'] = $user['id'];
        Userinfo::create($new_user_info);

        if ($request->has('is_superadmin')) {
            $user->assignRole('superadmin');
            $user->syncPermissions(null);
        } else {
            if ($request->has('roles') && $request->roles != null) {
                foreach ($request->roles as $iRole) {
                    $role = Role::findById($iRole);
                    $user->assignRole($role['name']);
                }
            }
            if ($request->has('permissions') && $request->permissions != null) {
                foreach ($request->permissions as $iPermission) {
                    $user->givePermissionTo($iPermission);
                }
            }
        }

        if ($request->has('send_mail')) {
            // thực hiện gửi mail or add vào hàng đợi
            $data = [
                'email' => $request->email,
                'password' => $request->password,
                'mail_title' => 'Thông tin tài khoản mới'
            ];
            Mail::send('User::mail.newuser', $data, function ($message) {
                global $request;
                $message->to($request->email, $request->display_name ? $request->display_name : $request->email)->subject('Thông tin tài khoản mới được tạo');
            });

            if (Mail::failures()) {
                return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'warning', 'message' => 'Đã thêm tài khoản thành công. Nhưng chưa gửi được email.']);
            } else {
                return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm tài khoản và gửi email thành công']);
            }
        }
        return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm tài khoản thành công']);
    }

    /**
     * edit user
     */
    public function getEditUser($id)
    {
        $user = User::where('id', $id)->with('roles')->get()->first();
        if ($user) {
            if (!$user->info) {
                Userinfo::create(['user_id' => $id]);
            }
            $arr_roles = [];
            foreach ($user->roles as $iRole) {
                $arr_roles[] = $iRole['id'];
            }
            $user['arr_roles'] = $arr_roles;
            $listPermissions = [];
            foreach ($user->permissions as $iPermission) {
                $listPermissions[] = $iPermission['name'];
            }
            $user['arr_permissions'] = $listPermissions;
            $data['user'] = $user;
            $data['page_title'] = 'Sửa tài khoản #' . $user['id'];

            $data['listRole'] = Role::where('name', '<>', 'superadmin')->orderBy('order', 'asc')->get();
            $listRoleWithPermissions = [];
            foreach ($data['listRole'] as $iRole) {
                foreach ($iRole->permissions as $iPermission) {
                    $listRoleWithPermissions[$iRole['id']][] = $iPermission['id'];
                }
            }
            $data['listRoleWithPermissions'] = json_encode($listRoleWithPermissions);
            $data['listDepartment'] = Department::orderBy('name', 'asc')->get();
            return view('User::admin.user.edit', $data);
        }

        return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy tài khoản để sửa']);
    }

    /**
     * post edit user
     */
    public function postEditUser($id, Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email,' . $id,
            'repassword' => 'same:password'
        ], [
            'email.required' => 'Chưa nhập email',
            'email.unique' => 'Email đã tồn tại',
            'repassword.same' => 'Hai mật khẩu không khớp'
        ]);

        $data_update = [
            'email' => $request->email,
            'display_name' => $request->display_name ? $request->display_name : $request->email,
            'status' => auth('admin')->id() == $id ? 1 : $request->status,
        ];

        if (!empty($request->password)) {
            $data_update['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($data_update);
        $user = User::find($id, ['id']);
        Userinfo::where('user_id', $id)->update($request->info);
        if ($request->has('is_superadmin')) {
            $user->syncRoles(['superadmin']);
            $user->syncPermissions(null);
        } else {
            if ($request->has('roles') && $request->roles != null) {
                $tmpRoles = [];
                foreach ($request->roles as $iRole) {
                    $role = Role::findById($iRole);
                    $tmpRoles[] = $role['name'];
                }
                $user->syncRoles($tmpRoles);
            } else {
                $user->syncRoles(null);
            }

            if ($request->has('permissions') && $request->permissions != null) {
                $user->syncPermissions($request->permissions);
            } else {
                $user->syncPermissions(null);
            }
        }

        if ($request->has('send_mail')) {
            // thực hiện gửi mail or add vào hàng đợi
            $data = [
                'email' => $request->email,
                'password' => $request->password,
                'mail_title' => 'Thông tin tài khoản mới'
            ];
            Mail::send('User::mail.newuser', $data, function ($message) {
                global $request;
                $message->to($request->email, $request->display_name ? $request->display_name : $request->email)->subject('Thông tin tài khoản mới được tạo');
            });

            if (Mail::failures()) {
                return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'warning', 'message' => 'Đã thêm tài khoản thành công. Nhưng chưa gửi được email.']);
            } else {
                return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'success', 'message' => 'Đã thêm tài khoản và gửi email thành công']);
            }
        }
        return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật thông tin tài khoản thành công']);
    }

    /**
     * delete user
     */
    public function getDeleteUser($id)
    {
        if (auth('admin')->id() == $id) {
            return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'error', 'message' => 'Không thể xóa tài khoản của chính mình']);
        }
        $user = User::find($id);
        $user->syncPermissions(null);
        $user->syncRoles(null);
        $user->info()->delete();
        User::where('id', $id)->delete();

        return redirect()->route('mod_user.admin.list_user')->with('flash_data', ['type' => 'success', 'message' => 'Tất cả dữ liệu liên quan đến tài khoản đã bị xóa']);
    }

    public function ajaxChangeStatus(Request $request)
    {
        try {
            if (auth('admin')->id() == $request->id) {
                return response()->json(['status' => false, 'msg' => 'Không thể cập nhật trạng thái của chính mình']);
            }
            $user  = User::find($request->id);
            if ($user->hasRole('superadmin') && !auth('admin')->user()->hasRole('superadmin')) {
                return response()->json(['status' => false, 'msg' => 'Không thể cập nhật trạng thái của Super Admin']);
            } else {
                User::where('id', $request->id)->update([
                    'status' => $request->status,
                ]);
            }
            return response()->json(['status' => true, 'msg' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra']);
        }
    }
}