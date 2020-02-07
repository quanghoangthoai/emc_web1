<?php

use Illuminate\Support\Facades\Schema;
use System\Core\Models\Config;
use System\Core\Models\Module;

global $global_config;
global $active_modules;
global $deactive_modules;
global $installed_modules;

/**
 * Init data to $global_config
 */
$tmpConfigs = [];
if (Schema::hasTable('configs')) {
    $tmpConfigs = Cache::remember('global_config', 60, function () {
        return Config::where('module', 'global')->get(['name', 'value']);
    });
} else {
    Cache::flush();
}

$global_config = null;
if ($tmpConfigs) {
    foreach ($tmpConfigs as $iConfig) {
        $global_config[$iConfig['name']] = $iConfig['value'];
    }
}

/**
 * Init data to $installed_modules
 */
// Reset data
$installed_modules = [];
$active_modules = [];
$deactive_modules = [];
// Get list modules from DB or cache
$tmpInstalledModules = [];
if (Schema::hasTable('modules')) {
    $tmpInstalledModules = Cache::remember('installed_modules', 60, function () {
        return Module::orderBy('order', 'asc')->get(['name', 'status']);
    });
} else {
    Cache::flush();
}

if ($tmpInstalledModules) {
    foreach ($tmpInstalledModules as $iTmpMod) {
        $installed_modules[] = $iTmpMod['name'];
        if ($iTmpMod['status'] == 1) {
            $active_modules[] = $iTmpMod['name'];
        } else {
            $deactive_modules[] = $iTmpMod['name'];
        }
    }
}