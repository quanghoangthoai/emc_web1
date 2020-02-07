<?php

use System\Core\Models\Module;

function cms_fix_module_order()
{
    $listMod = Module::orderBy('order', 'asc')->get(['name']);
    $weight = 0;
    foreach ($listMod as $mod) {
        ++$weight;
        Module::where('name', $mod['name'])->update([
            'order' => $weight
        ]);
    }
    return true;
}