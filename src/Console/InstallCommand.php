<?php

namespace Dotclang\AuthPackage\Console;

use Dotclang\AuthPackage\AuthServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    protected $signature = 'authpackage:install {--assets : Publish front-end assets (css/js/img)} {--force : Overwrite existing files}';

    protected $description = 'Install the AuthPackage (publish views, controllers, routes and merge config)';

    public function handle(): int
    {
        $provider = AuthServiceProvider::class;
        $this->info('⚡ Installing AuthPackage...');

        $force = $this->option('force');
        $assets = $this->option('assets');

        $this->info('Publishing configuration...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'auth-config',
            '--force' => $force,
        ]);

        $this->info('Publishing views...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'views',
            '--force' => $force,
        ]);

        $this->info('Publishing controllers...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'controllers',
            '--force' => $force,
        ]);

        // After controllers are published into the application's controllers folder,
        // rewrite the namespace and common package imports so they live under App\Http\Controllers
        $this->info('Rewriting controller namespaces to App namespace...');
        $fs = new Filesystem;
        $targetDir = app_path('Http/Controllers');

        if ($fs->isDirectory($targetDir)) {
            $files = $fs->allFiles($targetDir);
            foreach ($files as $file) {
                $path = $file->getPathname();
                $contents = $fs->get($path);

                // Skip if already adjusted
                if (str_contains($contents, 'namespace App\\')) {
                    continue;
                }

                // Replace package controller namespace with app controllers namespace
                $contents = str_replace(
                    'namespace Dotclang\\AuthPackage\\Http\\Controllers;',
                    'namespace App\\Http\\Controllers;',
                    $contents
                );

                // Replace common package imports to point to App equivalents
                $contents = str_replace('Dotclang\\AuthPackage\\Http\\Requests\\', 'App\\Http\\Requests\\', $contents);
                $contents = str_replace('Dotclang\\AuthPackage\\Models\\', 'App\\Models\\', $contents);

                // If view calls reference package view namespace, leave them as-is (developer can adjust)

                $fs->put($path, $contents);
                $this->info("Updated: {$path}");
            }
        } else {
            $this->comment('No published controllers found at: '.$targetDir);
        }

        $this->info('Publishing routes...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'routes',
            '--force' => $force,
        ]);

        // Merge published routes into application's routes/web.php
        $this->info('Rewriting published routes namespaces to App namespace...');
        $fsRoutes = new Filesystem;
        $routesDir = base_path('routes');

        if ($fsRoutes->isDirectory($routesDir)) {
            $files = $fsRoutes->allFiles($routesDir);
            foreach ($files as $file) {
                $path = $file->getPathname();
                $this->info('Rewriting file: '.$file->getFilename());
                $contents = $fsRoutes->get($path);

                // Skip if already adjusted
                if (str_contains($contents, 'use App\\')) {
                    continue;
                }

                // Skip if already adjusted
                if (str_contains($contents, 'use Illuminate\\')) {
                    continue;
                }

                // Replace package route namespace with app routes namespace
                $contents = str_replace(
                    'use Dotclang\\AuthPackage\\Http\\Controllers',
                    'use App\\Http\\Controllers',
                    $contents
                );

                $fsRoutes->put($path, $contents);
                $this->info("Updated: {$path}");
            }
        } else {
            $this->comment('No published routes found at: '.$routesDir);
        }

        if ($assets) {
            $this->info('Publishing front-end assets...');
            $this->callSilent('vendor:publish', [
                '--provider' => $provider,
                '--tag' => 'assets',
                '--force' => $force,
            ]);
        } else {
            if ($this->confirm('Would you like to publish the package front-end assets (css/js/img)?', false)) {
                $this->info('Publishing front-end assets...');
                $this->callSilent('vendor:publish', [
                    '--provider' => $provider,
                    '--tag' => 'assets',
                    '--force' => $force,
                ]);
            }
        }

        $this->line('Installation complete.');

        $this->comment('Remember to review your routes in routes/web.php and adjust middleware/auth as needed.');

        return Command::SUCCESS;
    }
}
