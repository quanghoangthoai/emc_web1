<?php

use System\Core\Models\Layout;

if (!function_exists('cms_layout_view')) {
    function cms_layout_view($view, $mod)
    {
        $layout = Layout::where('module', $mod)->where('view', $view)->first();

        return  $layout ? $layout['layout'] : 'main';
    }
}