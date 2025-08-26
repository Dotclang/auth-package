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
        $targetDir = app_path('Http/Controllers/AuthPackage');

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
        $this->info('Merging published routes into routes/web.php...');
        $fsRoutes = new Filesystem;
        $routesDir = base_path('routes');
        $mainWeb = $routesDir.DIRECTORY_SEPARATOR.'web.php';
        $marker = '// BEGIN DOTCLANG AUTH-PACKAGE ROUTES';

        if (! $fsRoutes->exists($mainWeb)) {
            // create web.php if it doesn't exist
            $fsRoutes->put($mainWeb, "<?php\n\n");
        }

        $webContents = $fsRoutes->get($mainWeb);

        // Avoid merging twice
        if (str_contains($webContents, $marker)) {
            $this->comment('Auth-package routes already merged into routes/web.php, skipping.');
        } else {
            $files = $fsRoutes->files($routesDir);
            foreach ($files as $file) {
                $path = $file->getPathname();
                $filename = $file->getFilename();

                // Skip the main web.php file itself
                if ($filename === 'web.php') {
                    // If the published web.php contains Dotclang references, extract and append
                    $candidate = $fsRoutes->get($path);
                    if (str_contains($candidate, 'Dotclang\\AuthPackage\\Http\\Controllers')) {
                        $candidate = str_replace('use Dotclang\\AuthPackage\\Http\\Controllers\\', 'use App\\Http\\Controllers\\', $candidate);
                        $append = "\n\n".$marker."\n".$candidate."\n// END DOTCLANG AUTH-PACKAGE ROUTES\n";
                        $fsRoutes->append($mainWeb, $append);
                        $this->info('Merged published web.php into routes/web.php');
                    }

                    continue;
                }

                // For other route files (like auth.php), merge if they reference package controllers
                $content = $fsRoutes->get($path);
                if (str_contains($content, 'Dotclang\\AuthPackage\\Http\\Controllers')) {
                    // rewrite controller use statements to App namespace
                    $content = str_replace('use Dotclang\\AuthPackage\\Http\\Controllers\\', 'use App\\Http\\Controllers\\', $content);

                    $append = "\n\n".$marker."\n".$content."\n// END DOTCLANG AUTH-PACKAGE ROUTES\n";
                    $fsRoutes->append($mainWeb, $append);
                    $this->info("Merged routes from {$filename} into routes/web.php");

                    // remove the published file to avoid duplicate route loading
                    $fsRoutes->delete($path);
                }
            }
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
