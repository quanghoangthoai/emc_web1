<?php

namespace System\Admin\Controllers;

use System\Core\Controllers\AdminController;
use File, Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use System\Core\Models\Module;

class ModuleController extends AdminController
{
    public function getListModule()
    {
        Cache::flush();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        /**
         * Get list modules not install
         */
        $listModules = cms_scan_folder(base_path('modules'));
        $not_install_modules = null;
        if ($listModules) {
            foreach ($listModules as $mod) {
                if (!module_check_installed($mod)) {
                    if (File::exists(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'info.json'))) {
                        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'info.json'));
                        $not_install_modules[] = $content;
                    }
                }
            }
        }

        /**
         * Get list installed modules
         */
        global $installed_modules;
        $data['listInstalledModules'] = Module::whereIn('name', $installed_modules)->orderBy('order', 'asc')->get();
        $data['not_install_modules'] = $not_install_modules;
        $data['minOrder'] = Module::min('order');
        $data['maxOrder'] = Module::max('order');
        return view('Admin::module.list', $data);
    }

    // Install a new module
    public function getInstallModule($module)
    {
        if (!File::exists(base_path('modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'info.json')) || module_check_installed($module)) {
            return redirect()->route('cms.admin.list_module')->with('flash_data', ['type' => 'error', 'message' => 'Không thể cài đặt module!']);
        }

        // Execute install module
        $action = "Modules\\$module\\Action";
        call_user_func([$action, 'install']);
        Cache::flush();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');

        // Log
        activity('module')
            // ->causedBy($user)
            ->withProperties(['name' => $module])
            ->log('install module');

        // Redirect
        return redirect()->route('cms.admin.edit_module', $module)->with('flash_data', ['type' => 'success', 'message' => 'Đã cài đặt module thành công. Hãy cập nhật thông tin module.']);
    }

    // Uninstall a module
    public function getUninstallModule($module)
    {
        // Execute uninstall module
        $action = "Modules\\$module\\Action";
        call_user_func([$action, 'uninstall']);
        Cache::flush();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');

        // Log
        activity('module')
            // ->causedBy($user)
            ->withProperties(['name' => $module])
            ->log('uninstall module');

        // Redirect
        return redirect()->route('cms.admin.list_module')->with('flash_data', ['type' => 'success', 'message' => 'Gỡ cài đặt module thành công.']);
    }

    public function getEditModule($name)
    {
        $data['module'] = Module::where('name', $name)->first();
        if ($data['module']) {
            return view('Admin::module.edit', $data);
        }
        return redirect()->route('cms.admin.list_module')->with('flash_data', ['type' => 'error', 'message' => 'Không tìm thấy module']);
    }

    public function postEditModule($name, Request $request)
    {
        $request->validate([
            'title' => 'required'
        ], [
            'title.required' => 'Chưa nhập tên module'
        ]);

        Module::where('name', $name)->update([
            'title' => $request->title,
            'icon' => $request->icon,
            'description' => $request->description,
            'status' => $request->has('status') ? 1 : 0
        ]);
        // Log
        activity('module')
            // ->causedBy($user)
            ->withProperties(['name' => $name])
            ->log('updated module');

        // Redirect
        return redirect()->route('cms.admin.list_module')->with('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);
    }

    public function ajaxChangeStatus(Request $request)
    {
        try {
            Module::where('name', $request->name)->update([
                'status' => $request->status
            ]);
            // Log
            activity('module')
                // ->causedBy($user)
                ->withProperties(['name' => $request->name])
                ->log('updated status module to ' . $request->status);

            // Redirect
            return response()->json(['status' => true, 'message' => 'Đã cập nhật trạng thái']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi']);
        }
    }

    /**
     * ajax change mod
     */
    public function ajaxChangeOrderModule(Request $request)
    {
        $mod = $request->mod;
        $order = $request->order;
        $listMod = Module::where([['name', '!=', $mod]])->orderBy('order', 'asc')->get(['name']);
        $weight = 0;
        foreach ($listMod as $module) {
            ++$weight;
            if ($weight == $order) {
                ++$weight;
            }
            Module::where('name', $module['name'])->update(['order' => $weight]);
        }
        Module::where('name', $mod)->update(['order' => $order]);
        cms_fix_module_order();
        Cache::flush();

        activity('module')
            // ->causedBy($user)
            ->withProperties(['name' => $mod])
            ->log('change order ' . $order);

        $request->session()->flash('flash_data', ['type' => 'success', 'message' => 'Cập nhật thành công']);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
        ]);
    }
}