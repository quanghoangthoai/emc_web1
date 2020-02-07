<?php

namespace System\Providers;

use Illuminate\Support\ServiceProvider;
use File;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        global $active_modules;

        if ($active_modules) {
            foreach ($active_modules as $mod) {
                // Load routes
                if (File::exists(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'routes.php'))) {
                    $this->loadRoutesFrom(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'routes.php'));
                }

                // Load helpers
                if (File::isDirectory(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'helpers'))) {
                    $helpers = File::glob(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . '*.php'));
                    foreach ($helpers as $helper) {
                        File::requireOnce($helper);
                    }
                }
                // Load configs
                if (File::isDirectory(base_path('modules') . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'config')) {
                    $configs = File::glob(base_path('modules') . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.php');
                    foreach ($configs as $config) {
                        $this->mergeConfigFrom($config, $mod . '::' . basename($config, '.php'));
                    }
                }
                // Load translations
                if (File::isDirectory(base_path('modules') . '/' . $mod . '/lang')) {
                    $this->loadTranslationsFrom(base_path('modules') . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'lang', $mod);
                }

                // Load views
                if (File::isDirectory(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'views'))) {
                    $this->loadViewsFrom(base_path('modules' . DIRECTORY_SEPARATOR . $mod . DIRECTORY_SEPARATOR . 'views'), $mod);
                }

                app('arrilot.widget-namespaces')->registerNamespace($mod, '\Modules\\' . $mod . '\Widgets');
            }
        }
    }
}