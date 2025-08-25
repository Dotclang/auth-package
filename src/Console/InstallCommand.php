<?php

namespace Dotclang\AuthPackage\Console;

use Dotclang\AuthPackage\AuthServiceProvider;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'authpackage:install {--force : Overwrite existing files} {--assets : Also publish front-end assets (css/js/img) to public/vendor}';

    protected $description = 'Install the AuthPackage (views, migrations, Tailwind setup)';

    public function handle(): int
    {
        $this->info('⚡ Installing AuthPackage...');

        // Ensure the package service provider is registered so its publishes are available
        // Registering unconditionally is fine during the console command execution.
        $this->laravel->register(AuthServiceProvider::class);

        // Publish views
        $viewPublishArgs = [
            '--provider' => \Dotclang\AuthPackage\AuthServiceProvider::class,
            '--tag' => 'views',
        ];

        if ($this->option('force')) {
            $viewPublishArgs['--force'] = true;
        }

        $this->call('vendor:publish', $viewPublishArgs);

        // Publish config (if exists in package)
        if (file_exists(__DIR__.'/../../config/auth.php') || file_exists(__DIR__.'/../../../config/auth.php')) {
            $configPublishArgs = [
                '--provider' => \Dotclang\AuthPackage\AuthServiceProvider::class,
                '--tag' => 'auth-config',
            ];
            if ($this->option('force')) {
                $configPublishArgs['--force'] = true;
            }
            $this->callSilent('vendor:publish', $configPublishArgs);
            $this->info('✅ Configuration published.');
        } else {
            $this->line('ℹ️  No package config found to publish.');
        }

        // Optionally publish front-end assets (css/js/img)
        if ($this->option('assets') || $this->confirm('Would you like to publish front-end assets (css/js/img) to your public/vendor directory?')) {
            $assetArgs = [
                '--provider' => \Dotclang\AuthPackage\AuthServiceProvider::class,
                '--tag' => 'assets',
            ];
            if ($this->option('force')) {
                $assetArgs['--force'] = true;
            }
            $this->call('vendor:publish', $assetArgs);
            $this->info('✅ Front-end assets published to public/vendor/Dotclang/auth-package');
        } else {
            $this->line('ℹ️  Skipped publishing front-end assets. You can publish them later with:');
            $this->line('    php artisan vendor:publish --provider="'.\Dotclang\AuthPackage\AuthServiceProvider::class.'" --tag=assets');
        }

        // Run migrations
        // $this->call('migrate');

        // Tailwind note
        $this->line('');
        $this->info('✅ Views and configuration published.');
        $this->warn('⚠️  Make sure TailwindCSS is installed in your project:');
        $this->line('   npm install -D tailwindcss postcss autoprefixer');
        $this->line('   npx tailwindcss init -p');
        $this->line('');
        $this->info('Add this to tailwind.config.js:');
        $this->line('   "./vendor/Dotclang/auth-package/resources/views/**/*.blade.php"');
        $this->line('');
        $this->info('Then run: npm run dev');

        return Command::SUCCESS;
    }
}
