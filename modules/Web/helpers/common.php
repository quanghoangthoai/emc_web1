<?php

use File as File;

function get_img_src($img_path = '')
{
    if (empty($img_path)) return asset('no-image.png');
    if (File::exists(public_path($img_path))) return asset($img_path);
    return asset('no-image.png');
}

function web_layouts()
{
    return ['main', 'left_main_right', 'left_main', 'main_right', 'home'];
}