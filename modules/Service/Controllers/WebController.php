<?php

namespace Modules\Service\Controllers;

use System\Core\Controllers\WebController as SystemWebController;
use Modules\Service\Models\Service;

class WebController extends  SystemWebController
{
    public static function detailService($service)
    {
        $id = $service['id'];
        $data['post'] = Service::where('id', $id)->first();
        $module = 'Service';
        foreach (mod_comment_get_data_comment($id, $module) as $key => $value) {
            $data[$key] = $value;
        }
        // dd($data['link']);
        $data['service'] = $service;
        Service::where('id', $service['id'])->update(['totalhits' => $service->totalhits + 1]);
        return view('Service::web.service', $data);
    }
}
