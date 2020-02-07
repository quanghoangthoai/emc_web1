<?php

namespace Modules\Client\Controllers;

use System\Core\Controllers\WebController;

class HomeController extends WebController
{
    public function getIndex()
    {
        return view('Client::index');
    }
}