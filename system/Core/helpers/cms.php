<?php

if (!function_exists('cms_scan_folder')) {
    /**
     * Scan folder and file in a folder
     *
     * @param [string] $path
     * @param array $ignore_files
     * @return [array]
     */
    function cms_scan_folder($path, $ignore_files = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..'], $ignore_files));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }
}

if (!function_exists('cms_readFileJSON')) {
    /**
     * Ham ho tro doc file json ra array
     *
     * @param [type] $file
     * @param boolean $convert_to_array
     * @return void
     */
    function cms_readFileJSON($file, $convert_to_array = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($convert_to_array) {
                return json_decode($file, true);
            } else {
                return $file;
            }
        }
        if (!$convert_to_array) {
            return null;
        }
        return [];
    }
}