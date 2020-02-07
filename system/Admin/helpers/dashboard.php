<?php

use Illuminate\Support\Facades\Cache;
use System\Core\Models\Module;

/**
 * Build menu dashboard
 */
function cms_dashboard_menu()
{
    global $user_info;
    $uid = isset($user_info['id']) ? $user_info['id'] : 0;
    return Cache::remember('cms_dashboard_menu_' . $uid, 30, function () {
        global $active_modules;
        $modules = $active_modules;
        $dashboard_menu = [];
        foreach ($modules as $mod) {
            $mod = Module::where('name', $mod)->first();
            if ($mod) {
                $module = $mod['name'];
                if (File::exists(base_path('modules') . DIRECTORY_SEPARATOR . $mod['name'] . DIRECTORY_SEPARATOR . 'admin_menu.php')) {
                    $submenu = [];
                    include base_path('modules') . DIRECTORY_SEPARATOR . $mod['name'] . DIRECTORY_SEPARATOR . 'admin_menu.php';
                    $_submenu = [];
                    foreach ($submenu as $isub) {
                        if (isset($isub['permission']) && check_permission($isub['permission']) || !isset($isub['permission'])) {
                            $_submenu[] = $isub;
                        }
                    }
                    if (count($_submenu) > 0) {
                        $dashboard_menu[] = [
                            'module' => $module,
                            'title' => $mod['title'],
                            'icon' => $mod['icon'] ? $mod['icon'] : config($module . '::module.icon'),
                            'submenu' => $_submenu,
                        ];
                    }
                }
            }
        }
        return $dashboard_menu;
    });
}