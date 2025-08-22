<?php

namespace Dotclang\AuthPackage;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AuthServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Register middleware alias
        if ($this->app->resolved('router')) {
            $router = $this->app->make('router');
            $router->aliasMiddleware('password.confirmed', \Dotclang\AuthPackage\Http\Middleware\RequirePasswordConfirmed::class);
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views (if you want blade-based login)
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'AuthPackage');

        // Publish config (merge into host app's auth config)
        $this->publishes([
            __DIR__ . '/../config/auth.php' => app()->configPath('auth.php'),
        ], 'auth-config');
    }

    public function register()
    {
        // Merge package auth config into host 'auth' config so auth.password_timeout is available
        $this->mergeConfigFrom(__DIR__ . '/../config/auth.php', 'auth');
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dotclang\AuthPackage\Console\InstallCommand::class,
            ]);
        }
    }
}
