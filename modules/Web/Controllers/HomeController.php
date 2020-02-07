<?php

namespace Modules\Web\Controllers;

use System\Core\Controllers\WebController;

class HomeController extends WebController
{
    public function getHome()
    {
        global $global_config;
        $data['page_title'] = $global_config['site_name'];
        return view('Web::index', $data);
    }
}