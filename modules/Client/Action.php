<?php

namespace Modules\Client;

use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Client' . DIRECTORY_SEPARATOR . 'info.json'));
        $max_order = Module::max('order');
        Module::create([
            'name' => $content['name'],
            'title' => $content['title'],
            'version' => $content['version'],
            'description' => $content['description'],
            'order' => $max_order ? $max_order + 1 : 1
        ]);
    }

    public static function uninstall()
    {
        Module::where('name', 'Client')->delete();
    }
}