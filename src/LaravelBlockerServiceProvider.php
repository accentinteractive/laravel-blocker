<?php

namespace Accentinteractive\LaravelBlocker;

use Accentinteractive\LaravelBlocker\Services\BlockedIpStoreDatabase;
use Illuminate\Support\ServiceProvider;

class LaravelBlockerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-blocker');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-blocker');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-blocker.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-blocker'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-blocker'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-blocker'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-blocker');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-blocker', function () {
            return new LaravelBlocker();
        });


        $blockedIpStoreClass = config('laravel-blocker.storage_implementation_class');
        $this->app->singleton('blockedipstore', function () use ($blockedIpStoreClass) {
            return new $blockedIpStoreClass();
        });
    }
}
