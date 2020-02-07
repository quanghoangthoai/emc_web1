<?php

use Illuminate\Support\Facades\Schema;
use System\Core\Models\Config;

if (!function_exists('cms_get_config')) {
    /**
     * Get a config cms
     *
     * @param string $config_name
     * @param mixed $default_value
     * @param string $module
     * @param string $lang
     * @return mixed
     */
    function cms_get_config($config_name, $default_value = null, $module = 'global', $lang = 'vi')
    {
        if (Schema::hasTable('configs')) {
            $config_value = Config::where(['lang' => $lang, 'module' => $module, 'name' => $config_name])->get(['value'])->first();
            if ($config_value) return $config_value['value'];
        }
        return $default_value;
    }
}

if (!function_exists('cms_set_config')) {
    /**
     * Set value to a config
     *
     * @param string $config_name
     * @param string $config_value
     * @param string $module
     * @param string $lang
     * @return void
     */
    function cms_set_config($config_name, $config_value = '', $module = 'global', $lang = 'vi')
    {
        try {
            if (Config::where(['lang' => $lang, 'module' => $module, 'name' => $config_name])->count() > 0) {
                Config::where(['lang' => $lang, 'module' => $module, 'name' => $config_name])->update(['value' => $config_value]);
            } else {
                Config::create([
                    'lang' => $lang,
                    'module' => $module,
                    'name' => $config_name,
                    'value' => $config_value
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

if (!function_exists('cms_remove_config')) {
    /**
     * Remove a config
     *
     * @param string $config_name
     * @param string $module
     * @param string $lang
     * @return void
     */
    function cms_remove_config($config_name, $module = 'global', $lang = 'vi')
    {
        try {
            return Config::where(['lang' => $lang, 'module' => $module, 'name' => $config_name])->delete();
        } catch (\Throwable $th) {
            return false;
        }
    }
}