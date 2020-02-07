<?php

namespace System\Providers;

use Illuminate\Support\ServiceProvider;
use File;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        view()->share('classFullsidebar', (!isset($_COOKIE['fullsidebar']) || (isset($_COOKIE['fullsidebar']) && $_COOKIE['fullsidebar'] == 'true')) ? '' : 'sidebar-xs');

        // Load routes
        if (File::exists(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'routes.php'))) {
            $this->loadRoutesFrom(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'routes.php'));
        }

        // Load helpers
        if (File::isDirectory(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'helpers'))) {
            $helpers = File::glob(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . '*.php'));
            foreach ($helpers as $helper) {
                File::requireOnce($helper);
            }
        }

        // Load configs
        if (File::isDirectory(base_path('system') . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'config')) {
            $configs = File::glob(base_path('system') . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.php');
            foreach ($configs as $config) {
                $this->mergeConfigFrom($config, 'Admin::' . basename($config, '.php'));
            }
        }

        // Load translations
        // if (File::isDirectory(base_path('modules') . '/' . $mod . '/lang')) {
        //     $this->loadTranslationsFrom(base_path('modules') . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'lang', $mod);
        // }

        // Load views
        if (File::isDirectory(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'views'))) {
            $this->loadViewsFrom(base_path('system' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'views'), 'Admin');
        }

        app('arrilot.widget-namespaces')->registerNamespace('Admin', '\System\Admin\Widgets');
    }
}