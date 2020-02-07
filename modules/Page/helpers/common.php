<?php

use Modules\Page\Models\Page;

/**
 * mod_page_fix_page_order()
 */
function mod_page_fix_page_order()
{
    $listPage = Page::select('id')->orderBy('order', 'asc')->get();
    $weight = 0;
    foreach ($listPage as $cat) {
        ++$weight;
        Page::where('id', $cat['id'])->update([
            'order' => $weight
        ]);
    }
    return true;
}