<?php

namespace Dotclang\AuthPackage;

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

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load views (if you want blade-based login)
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'AuthPackage');

        // Publish views and migrations so host apps can customize them
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/AuthPackage'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Publish front-end assets (CSS/JS/images) so host apps without Vite can publish them to public/
        $this->publishes([
            __DIR__.'/../resources/css' => public_path('vendor/Dotclang/auth-package/css'),
            __DIR__.'/../resources/js' => public_path('vendor/Dotclang/auth-package/js'),
            __DIR__.'/../resources/images' => public_path('vendor/Dotclang/auth-package/images'),
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
