<?php

namespace Dotclang\AuthPackage;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AuthServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        // Register middleware alias
        if ($this->app->resolved('router')) {
            $router = $this->app->make('router');
            $router->aliasMiddleware('password.confirmed', \Dotclang\AuthPackage\Http\Middleware\RequirePasswordConfirmed::class);
        }

        // Load package web and auth routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');

        // Load views (if you want blade-based login)
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'AuthPackage');

        // Publish views and migrations so host apps can customize them
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/AuthPackage'),
        ], 'views');

        // Publish front-end assets (CSS/JS/images) so host apps without Vite can publish them to public/
        // NOTE: resources images live under resources/img in this package.
        $this->publishes([
            __DIR__.'/../resources/css' => public_path('vendor/Dotclang/auth-package/css'),
            __DIR__.'/../resources/js' => public_path('vendor/Dotclang/auth-package/js'),
            __DIR__.'/../resources/img' => public_path('vendor/Dotclang/auth-package/img'),
        ], 'assets');

        // Publish config (merge into host app's auth config)
        $this->publishes([
            __DIR__.'/../config/auth.php' => app()->configPath('auth.php'),
        ], 'auth-config');
    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dotclang\AuthPackage\Console\InstallCommand::class,
            ]);
        }
    }
}
