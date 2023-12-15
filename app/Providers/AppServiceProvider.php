<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Providers\MigodaServiceProvider;
use BeyondCode\LaravelWebSockets\WebSocketsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() === 'local') {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }
        $this->app->register(WebSocketsServiceProvider::class);
        $this->app->register(MigodaServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
