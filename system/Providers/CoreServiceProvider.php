<?php

namespace System\Providers;

use Illuminate\Support\ServiceProvider;
use File;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Load global_variables
        global $global_config, $active_modules;
        File::requireOnce(base_path('system' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'global_variables.php'));
        view()->share('global_config', $global_config);
        view()->share('active_modules', $active_modules);
        config([
            'mail.driver' => 'smtp',
            'mail.host' => isset($global_config['mail_host']) ? $global_config['mail_host'] : '',
            'mail.port' => isset($global_config['mail_port']) ? intval($global_config['mail_port']) : '',
            'mail.encryption' => isset($global_config['mail_encryption']) ? $global_config['mail_encryption'] : '',
            'mail.username' => isset($global_config['mail_username']) ? $global_config['mail_username'] : '',
            'mail.password' => isset($global_config['mail_password']) ? $global_config['mail_password'] : '',
            'mail.from.address' => isset($global_config['mail_from_address']) ? $global_config['mail_from_address'] : '',
            'mail.from.name' => isset($global_config['mail_from_name']) ? $global_config['mail_from_name'] : '',

            'services.facebook' => [
                'client_id' => isset($global_config['facebook_app_id']) ? $global_config['facebook_app_id'] : '',
                'client_secret' => isset($global_config['facebook_app_secret']) ? $global_config['facebook_app_secret'] : '', // Your GitHub Client Secret
                'redirect' => url('auth/facebook/callback'),
            ],
            'services.google' => [
                'client_id' => isset($global_config['google_app_id']) ? $global_config['google_app_id'] : '',
                'client_secret' => isset($global_config['google_app_secret']) ? $global_config['google_app_secret'] : '', // Your GitHub Client Secret
                'redirect' => url('auth/google/callback'),
            ],
        ]);
        // Load routes
        if (File::exists(base_path('system' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'routes.php'))) {
            $this->loadRoutesFrom(base_path('system' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'routes.php'));
        }

        // Load helpers
        if (File::isDirectory(base_path('system' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'helpers'))) {
            $helpers = File::glob(base_path('system' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . '*.php'));
            foreach ($helpers as $helper) {
                File::requireOnce($helper);
            }
        }
    }
}