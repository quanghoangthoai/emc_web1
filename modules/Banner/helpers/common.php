<?php

use Modules\Banner\Models\Banner;
use Modules\Banner\Models\Block;

function mod_banner_get_list_block($active = 0)
{
    if ($active) Block::where('status', 1)->get();
    return Block::all();
}

function mod_banner_get_list_banner($block, $limit = 1)
{
    return Banner::where('block_id', $block)->limit($limit)->get();
}