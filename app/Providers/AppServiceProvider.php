<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // productionではhttpsを強制する
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        } else if (\App::environment('local')) {
            \URL::forceScheme('http');
        }
    }
}
