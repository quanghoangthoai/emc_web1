<?php

namespace System\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use System\Core\Commands\CreateModule;

class SystemServiceProvider extends ServiceProvider
{
    public function register()
    {
        // register
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        /**
         * Load Commands
         */
        $this->commands([
            CreateModule::class,
        ]);

        /**
         * Register Services
         */
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(AdminServiceProvider::class);
        $this->app->register(ModuleServiceProvider::class);
        $this->app->register(ShortcodesServiceProvider::class);
    }
}