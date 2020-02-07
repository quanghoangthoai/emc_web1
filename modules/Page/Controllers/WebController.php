<?php

namespace Modules\Page\Controllers;

use System\Core\Controllers\WebController as SystemWebController;

class WebController extends SystemWebController
{
    public static function getDetailPage($page)
    {
        $data['page'] = $page;
        return view('Page::web.detail_page', $data); // ->withShortcodes()
    }
}