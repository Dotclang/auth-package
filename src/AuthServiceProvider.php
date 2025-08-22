<?php

namespace Dotclang\AuthPackage;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AuthServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views (if you want blade-based login)
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'AuthPackage');

        // Publish config
        $this->publishes([
            __DIR__ . '/../config/auth.php' => app()->configPath('auth.php'),
        ], 'config');
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/auth.php', 'AuthPackage');
    }
}
