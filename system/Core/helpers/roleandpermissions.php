<?php

use System\Core\Models\Module;
use System\Core\Models\Permission;
use System\Core\Models\Role;

function check_system_roles()
{
    foreach (config('permission.system_roles') as $sRole) {
        if (Role::where('name', $sRole['name'])->count() == 0) {
            Role::create($sRole);
        }
    }
    role_fix_order();
}

if (!function_exists('is_superadmin')) {
    /**
     * check if user is an admin
     */
    function is_superadmin()
    {
        if (!auth('admin')->check()) return false;
        return auth('admin')->user()->hasRole('superadmin');
    }
}

if (!function_exists('check_permission')) {
    /**
     * check if user has a permission
     */
    function check_permission($permission = '')
    {
        if (is_superadmin()) return true;
        if (Permission::where('name', $permission)->count())
            return auth('admin')->user()->hasPermissionTo($permission);
        return false;
    }
}

/**
 * role_fix_order()
 */
function role_fix_order()
{
    $listRole = Role::orderBy('order', 'asc')->get(['id']);
    $weight = 0;
    foreach ($listRole as $role) {
        ++$weight;
        Role::where('id', $role['id'])->update([
            'order' => $weight
        ]);
    }
    return true;
}

function get_list_permissions()
{
    global $active_modules;
    $modules = $active_modules;
    $list_permissions = [];
    foreach ($modules as $mod) {
        $mod = Module::where('name', $mod)->first();
        if ($mod) {
            $listPermission = Permission::where('type', 'module')->where('module', $mod['name'])->get();
            if ($listPermission && count($listPermission) > 0) {
                $list_permissions[] = [
                    'module' => $mod['name'],
                    'title' => $mod['title'],
                    'icon' => config($mod['name'] . '::module.icon'),
                    'permissions' => $listPermission
                ];
            }
        }
    }

    $listPermission = Permission::where('type', 'system')->get();
    if ($listPermission && count($listPermission) > 0) {
        $list_permissions[] = [
            'module' => 'System',
            'title' => 'Hệ thống',
            'icon' => 'fa fa-cogs',
            'permissions' => $listPermission
        ];
    }
    return $list_permissions;
}

function sync_all_permissions()
{
    global $active_modules;
    $new_permissions = []; // contain all id of final permissions

    // get all system permissions
    // foreach permission of module
    // if (permission_name not in DB) insert
    /// get id of permission => $new_permissions
    if (File::exists(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'permissions.php'))) {
        $permissions = null;
        include base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'permissions.php');
        if ($permissions) {
            foreach ($permissions as $iPermission) {
                $permission = Permission::where('name', $iPermission['name'])->where('type', 'system')->first();
                if (!$permission) {
                    $iPermission['module'] = null;
                    $iPermission['type'] = 'system';
                    $permission = Permission::create($iPermission);
                }
                $new_permissions[] = $permission['id'];
            }
        }
    }

    // foreach active modules
    //// get all module permissions
    //// foreach permission of module
    ////// if (permission_name not in DB) insert
    /////// get id of permission => $new_permissions
    $modules = $active_modules;
    foreach ($modules as $mod) {
        if (File::exists(base_path('modules') . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'permissions.php')) {
            $permissions = null;
            include base_path('modules') . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'permissions.php';
            if ($permissions) {
                foreach ($permissions as $iPermission) {
                    $permission = Permission::where('name', $iPermission['name'])->where('type', 'module')->where('module', $mod)->first();
                    if (!$permission) {
                        $iPermission['module'] = $mod;
                        $iPermission['type'] = 'module';
                        $permission = Permission::create($iPermission);
                    }
                    $new_permissions[] = $permission['id'];
                }
            }
        }
    }
    // get all permissions not in $new_permissions => remove
    Permission::whereNotIn('id', $new_permissions)->delete();
}