<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Ensure any Console Command resolved from the container receives the
// Laravel application instance so `$this->laravel` is not null when
// Symfony's container-based lazy loader instantiates commands.
$app->afterResolving(\Symfony\Component\Console\Command\Command::class, function ($command) use ($app) {
    if ($command instanceof \Illuminate\Console\Command) {
        $command->setLaravel($app);
    }
});

// Ensure the package view namespace is available even if the provider hasn't
// yet run (prevents "No hint path defined for [AuthPackage]" when compiled
// views reference the namespace early).
$app->afterResolving('view.finder', function ($finder) use ($app) {
    // Map the AuthPackage namespace to the package's resources/views folder.
    $finder->addNamespace('AuthPackage', $app->resourcePath('views'));
});

// Point the application "app" directory at our package `src/` so the
// framework's namespace detection (which reads composer.json PSR-4) can
// find the package namespace. This avoids the "Unable to detect
// application namespace" error when bootstrapping commands.
$app->useAppPath($app->basePath('src'));

return $app;
