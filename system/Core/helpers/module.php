<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use System\Core\Models\Module;

if (!function_exists('module_info')) {
    /**
     * Check if is an installed module
     *
     * @param [string] $module
     * @return bool
     */
    function module_info($module)
    {
        $module_info = Module::where('name', $module)->first()->toArray();
        $module_info['icon'] = $module_info['icon'] ?? config($module . '::module.icon');
        return $module_info;
    }
}

if (!function_exists('module_check_installed')) {
    /**
     * Check if is an installed module
     *
     * @param [string] $module
     * @return bool
     */
    function module_check_installed($module)
    {
        global $installed_modules;
        return in_array($module, $installed_modules);
    }
}

if (!function_exists('module_check_active')) {
    /**
     * Check if is an active module
     *
     * @param [string] $module
     * @return bool
     */
    function module_check_active($module)
    {
        global $active_modules;
        return in_array($module, $active_modules);
    }
}

function check_install_mod_user()
{
    if (!module_check_installed('User')) {
        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'User' . DIRECTORY_SEPARATOR . 'info.json'));
        $max_order = Module::max('order');
        Module::create([
            'name' => $content['name'],
            'title' => $content['title'],
            'version' => $content['version'],
            'description' => $content['description'],
            'order' => $max_order ? $max_order + 1 : 1
        ]);

        Cache::flush();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');

        // Log
        activity('module')
            // ->causedBy($user)
            ->withProperties(['name' => 'User'])
            ->log('install module');
    }
}