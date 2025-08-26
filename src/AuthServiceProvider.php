<?php

namespace Dotclang\AuthPackage;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AuthServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        // Load auth routes
        if (file_exists(__DIR__.'/../routes/auth.php')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');
        }

        // Load web routes
        if (file_exists(__DIR__.'/../routes/web.php')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        // Publish package route files so the app can customize them
        $this->publishes([
            __DIR__.'/../routes' => base_path('routes'),
        ], 'routes');

        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ], 'auth-config');

        // Publish views so application can override them
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views'),
        ], 'views');

        // Publish controllers, requests and middleware
        $this->publishes([
            __DIR__.'/Http/Controllers' => app_path('Http/Controllers'),
            __DIR__.'/Http/Requests' => app_path('Http/Requests'),
            __DIR__.'/Http/Middleware' => app_path('Http/Middleware'),
        ], 'controllers');

        // Optional front-end assets publish
        $this->publishes([
            __DIR__.'/../resources/css' => resource_path('vendor/dotclang/auth-package/css'),
            __DIR__.'/../resources/js' => resource_path('vendor/dotclang/auth-package/js'),
            __DIR__.'/../resources/img' => resource_path('vendor/dotclang/auth-package/img'),
        ], 'assets');
    }

    public function register(): void
    {
        // Merge package auth config into application's auth config
        $this->mergeConfigFrom(__DIR__.'/../config/auth.php', 'auth');

        // Register the install command when running in the console
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dotclang\AuthPackage\Console\InstallCommand::class,
            ]);
        }
    }
}
