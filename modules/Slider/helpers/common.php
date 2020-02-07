<?php

use Modules\Slider\Models\Block;
use Modules\Slider\Models\Slide;

function mod_slider_block()
{
    $list_Block = Block::orderBy('id', 'asc')->get();
    return $list_Block;
}

function mod_slider_fix_oder()
{
    $listSlide = Slide::select('id')->orderBy('order', 'asc')->get();
    $weight = 0;
    foreach ($listSlide as $iSlide) {
        ++$weight;
        Slide::where('id', $iSlide['id'])->update([
            'order' => $weight
        ]);
    }
    return true;
}