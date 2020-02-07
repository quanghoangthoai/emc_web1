<?php

use System\Admin\Models\AdminWidget;
use Widget as Widget;

/**
 * get all list widget of a module
 */
function get_widgets_module($module_name)
{
    $path_to_widget = base_path('modules' . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR . 'Widgets');
    $classPaths = cms_scan_folder($path_to_widget);
    $classes = array();
    foreach ($classPaths as $classPath) {
        $segments = explode('/', $classPath);
        $segments = explode('\\', $segments[count($segments) - 1]);
        $rClass = preg_replace('/\\.[^.\\s]{3,4}$/', '', $segments[count($segments) - 1]);
        if (method_exists('Modules\\' . $module_name . '\Widgets\\' . $rClass, 'config_view')) {
            $classes[] = [
                'value' => $rClass,
                'hasConfig' => 1
            ];
        } else {
            $classes[] = [
                'value' => $rClass,
                'hasConfig' => 0
            ];
        }
    }
    return $classes;
}

/**
 * list module had widgets
 */
function get_list_module_has_widget()
{
    global $active_modules;
    $listMod = $active_modules;
    $result = [
        ['name' => 'Admin', 'title' => 'Admin']
    ];
    foreach ($listMod as $mod) {
        if (count(get_widgets_module($mod)) > 0) {
            $result[] = $mod;
        }
    }
    return $result;
}

/**
 * list template widget
 */
function get_list_template_widget()
{
    $path_to_widget_tpl = base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'widget_tpl');
    $listTpl = cms_scan_folder($path_to_widget_tpl);
    foreach ($listTpl as $k => $iTpl) {
        $listTpl[$k] = preg_replace('/\\.[^.\\s]{5}\\.[^.\\s]{3}$/', '', $iTpl);
    }
    return $listTpl;
}

/**
 * cms_fix_widget_order()
 */
function cms_fix_widget_order()
{
    $listPosition = config('widget.position');
    foreach ($listPosition as $position) {
        $listWidget = Widget::select('id')->where('position', $position)->orderBy('order', 'asc')->get();
        $weight = 0;
        foreach ($listWidget as $widget) {
            ++$weight;
            Widget::where('id', $widget['id'])->update([
                'order' => $weight
            ]);
        }
    }
    return true;
}


if (!function_exists('cms_load_widget_admin')) {
    /**
     * Auto render all widget admin
     *
     * @return void
     */
    function cms_load_widget_admin()
    {
        // get list widget admin status = 1
        $listWidget = Cache::remember('list_widget_admin', 30, function () {
            return AdminWidget::where('status', 1)->get();
        });

        if ($listWidget) {
            foreach ($listWidget as $widget) {
                $widget['config'] = json_decode($widget['config'] ? $widget['config'] : '[]', true);
                // add widget to group
                Widget::group($widget['group'])->position($widget['order'])->addWidget($widget['module'] . '::' . $widget['name'], $widget);
            }
        }
    }
}