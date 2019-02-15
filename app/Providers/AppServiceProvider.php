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
        $this->app->bind(\Upwork\API\Client::class, function ($app) {
            $config = new \Upwork\API\Config([
                'consumerKey'    => env('UPWORK_APP_KEY'),
                'consumerSecret' => env('UPWORK_APP_SECRET_KEY'),
                'accessToken'    => env('UPWORK_ACCESS_TOKEN') ?? null,
                'accessSecret'   => env('UPWORK_ACCESS_SECRET') ?? null
            ]);

            return new \Upwork\API\Client($config);
        });
    }
}
