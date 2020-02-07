<?php

namespace Modules\Product\Shortcodes;

use Modules\Product\Models\Product;

class ProductShortcode
{
    public function register($shortcode, $content, $compiler, $name, $viewData)
    {
        $ids = $shortcode->get('ids');
        $ids = explode('=', $ids);
        $ids = trim(end($ids), "\"");
        $ids = explode(',', $ids);
        if ($ids) {
            $listProduct = [];
            foreach ($ids as $id) {
                $product = Product::find($id);
                if ($product) $listProduct[] = $product;
            }
            return view('Product::shortcode.list_product')->with('listProduct', $listProduct)->render();
        }
        return '';
    }
}