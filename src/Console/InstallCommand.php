<?php

namespace Dotclang\AuthPackage\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'authpackage:install {--force : Overwrite existing files} {--assets : Also publish front-end assets (css/js/img) to public/vendor}';

    protected $description = 'Install the AuthPackage (views, migrations, Tailwind setup)';

    public function handle(): int
    {
        $this->info('⚡ Installing AuthPackage...');

        // Publish views
        $this->call('vendor:publish', [
            '--provider' => "Dotclang\AuthPackage\AuthServiceProvider",
            '--tag' => 'views',
            '--force' => $this->option('force'),
        ]);

        // Publish config (if exists)
        $this->callSilent('vendor:publish', [
            '--provider' => "Dotclang\AuthPackage\AuthServiceProvider",
            '--tag' => 'auth-config',
            '--force' => $this->option('force'),
        ]);

        // Optionally publish front-end assets (css/js/img)
        if ($this->option('assets') || $this->confirm('Would you like to publish front-end assets (css/js/img) to your public/vendor directory?')) {
            $this->call('vendor:publish', [
                '--provider' => "Dotclang\AuthPackage\AuthServiceProvider",
                '--tag' => 'assets',
                '--force' => $this->option('force'),
            ]);
            $this->info('✅ Front-end assets published to public/vendor/Dotclang/auth-package');
        } else {
            $this->line('ℹ️  Skipped publishing front-end assets. You can publish them later with:');
            $this->line('    php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag=assets');
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
