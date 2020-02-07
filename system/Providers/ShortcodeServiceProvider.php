<?php

namespace System\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Shortcodes\ProductShortcode;
use Shortcode;

class ShortcodesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Shortcode::register('product', ProductShortcode::class);
    }
}