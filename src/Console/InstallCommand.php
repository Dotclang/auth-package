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
        $this->info('⚡ Installing AuthPackage...');
        $provider = AuthServiceProvider::class;

        $force = (bool) $this->option('force');
        $assets = (bool) $this->option('assets');

        $fs = new Filesystem();

        // Publish configuration
        $this->info('Publishing configuration...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'auth-config',
            '--force' => $force,
        ]);

        // Publish views
        $this->info('Publishing views...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'views',
            '--force' => $force,
        ]);

        // Publish routes
        $this->info('Publishing routes...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'controllers',
            '--force' => $force,
        ]);

        // Rewrite namespaces in published controllers (only files that reference the package namespace)
        $this->info('Rewriting controller namespaces to App namespace...');
        $controllersDir = app_path('Http/Controllers');
        if ($fs->isDirectory($controllersDir)) {
            $files = $fs->allFiles($controllersDir);
            foreach ($files as $file) {
                $path = $file->getPathname();
                $contents = $fs->get($path);

                if (! str_contains($contents, 'Dotclang\\AuthPackage')) {
                    continue;
                }

                // Replace namespace declaration if present
                $contents = str_replace('namespace Dotclang\\AuthPackage\\Http\\Controllers;', 'namespace App\\Http\\Controllers;', $contents);

                // Replace common imports/references
                $contents = str_replace('Dotclang\\AuthPackage\\Http\\Requests\\', 'App\\Http\\Requests\\', $contents);
                $contents = str_replace('Dotclang\\AuthPackage\\Models\\', 'App\\Models\\', $contents);

                $fs->put($path, $contents);
                $this->info('Updated controller: ' . $path);
            }
        } else {
            $this->comment('No controllers directory found at: ' . $controllersDir);
        }

        // Publish and copy package route files into application's routes directory, rewriting controller namespaces
        $this->info('Publishing and copying package route files...');

        // run vendor:publish for tag 'routes' first (keeps standard flow)
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'routes',
            '--force' => $force,
        ]);

        $packageRoutesDir = __DIR__ . '/../../routes';
        $appRoutesDir = base_path('routes');

        if (! $fs->isDirectory($packageRoutesDir)) {
            $this->comment('No package route files found to publish in: ' . $packageRoutesDir);
        } else {
            $files = $fs->files($packageRoutesDir);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $source = $file->getPathname();
                $target = $appRoutesDir . DIRECTORY_SEPARATOR . $filename;

                $contents = $fs->get($source);

                // Rewrite controller references: use statements and fully-qualified class names
                $contents = str_replace('use Dotclang\\AuthPackage\\Http\\Controllers\\', 'use App\\Http\\Controllers\\', $contents);
                $contents = str_replace('Dotclang\\AuthPackage\\Http\\Controllers\\', 'App\\Http\\Controllers\\', $contents);

                // Also fix requests namespace in routes if used
                $contents = str_replace('Dotclang\\AuthPackage\\Http\\Requests\\', 'App\\Http\\Requests\\', $contents);

                // Write file to app routes directory, honoring --force or asking interactively
                if ($fs->exists($target)) {
                    if ($force) {
                        $fs->put($target, $contents);
                        $this->info("Replaced existing route: {$target}");
                    } else {
                        if ($this->confirm("routes/{$filename} already exists. Overwrite?", false)) {
                            $fs->put($target, $contents);
                            $this->info("Replaced existing route: {$target}");
                        } else {
                            $this->comment("Skipped route: {$filename}");
                        }
                    }
                } else {
                    $fs->put($target, $contents);
                    $this->info("Published route: {$target}");
                }
            }
        }

        // Publish controllers
        $this->info('Publishing controllers...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'controllers',
            '--force' => $force,
        ]);

        // Rewrite namespaces in published controllers (only files that reference the package namespace)
        $this->info('Rewriting controller namespaces to App namespace...');
        $controllersDir = app_path('Http/Controllers');
        if ($fs->isDirectory($controllersDir)) {
            $files = $fs->allFiles($controllersDir);
            foreach ($files as $file) {
                $path = $file->getPathname();
                $contents = $fs->get($path);

                if (! str_contains($contents, 'Dotclang\\AuthPackage')) {
                    continue;
                }

                // Replace namespace declaration if present
                $contents = str_replace('namespace Dotclang\\AuthPackage\\Http\\Controllers;', 'namespace App\\Http\\Controllers;', $contents);

                // Replace common imports/references
                $contents = str_replace('Dotclang\\AuthPackage\\Http\\Requests\\', 'App\\Http\\Requests\\', $contents);
                $contents = str_replace('Dotclang\\AuthPackage\\Models\\', 'App\\Models\\', $contents);

                $fs->put($path, $contents);
                $this->info('Updated controller: ' . $path);
            }
        } else {
            $this->comment('No controllers directory found at: ' . $controllersDir);
        }


        // Optional assets
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
        $this->comment('Review published controllers and routes. Adjust view references or namespace choices if required.');

        return Command::SUCCESS;
    }
}
