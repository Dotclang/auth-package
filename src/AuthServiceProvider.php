<?php

namespace Dotclang\AuthPackage;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AuthServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        // Load package routes (so package works out of the box)
        if (file_exists(__DIR__ . '/../routes/auth.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');
        }

        // Load package views under the "auth-package" namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'auth-package');

        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/auth.php' => config_path('auth.php'),
        ], 'auth-config');

        // Publish views so application can override them
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/auth-package'),
        ], 'views');

        // Publish controllers into the application's Http/Controllers directory
        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers/AuthPackage'),
        ], 'controllers');

        // Publish package route files so the app can customize them
        $this->publishes([
            __DIR__ . '/../routes' => base_path('routes'),
        ], 'routes');

        // Optional front-end assets publish
        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('vendor/dotclang/auth-package/css'),
            __DIR__ . '/../resources/js' => public_path('vendor/dotclang/auth-package/js'),
            __DIR__ . '/../resources/img' => public_path('vendor/dotclang/auth-package/img'),
        ], 'assets');
    }

    public function register(): void
    {
        // Merge package auth config into application's auth config
        $this->mergeConfigFrom(__DIR__ . '/../config/auth.php', 'auth');

        // Register the install command when running in the console
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dotclang\AuthPackage\Console\InstallCommand::class,
            ]);
        }
    }
}
