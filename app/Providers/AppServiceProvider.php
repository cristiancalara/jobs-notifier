<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Warning in upwork php wrapper
        error_reporting(0);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
