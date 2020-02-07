<?php

if (!function_exists('get_list_widget_admin')) {
    /**
     * Get list widgets for admin spaces
     *
     * @return array
     */
    function get_list_widget_admin()
    {
        global $active_modules;

        $result = [];
        /**
         * List widgets of Admin
         */
        $result['Admin'] = config('Admin::widget.admin');

        /**
         * List widgets of Modules
         */
        if ($active_modules) {
            foreach ($active_modules as $mod) {
                $result[$mod] = config($mod . '::widget.admin');
            }
        }

        return $result;
    }
}