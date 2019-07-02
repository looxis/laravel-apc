<?php

namespace Looxis\Laravel\APC;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class APCServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-apc-client.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-apc-client');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-apc', function () {
            $client = new Client([
                'base_uri' => config('config.base_uri'),
                "headers" => [
                    "Content-Type" => "application/json",
                    "X-Requested-With" => "XMLHttpRequest",
                    "Authorization" => "Bearer " . config('config.key')
                ]
            ]);

            return new APC($client);
        });
    }
}
