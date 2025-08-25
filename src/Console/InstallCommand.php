<?php

namespace Dotclang\AuthPackage\Console;

use Dotclang\AuthPackage\AuthServiceProvider;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'authpackage:install {--assets : Publish front-end assets (css/js/img)} {--force : Overwrite existing files}';

    protected $description = 'Install the AuthPackage (publish views, controllers, routes and merge config)';

    public function handle(): int
    {
        $provider = AuthServiceProvider::class;

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

        $this->info('Publishing routes...');
        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'routes',
            '--force' => $force,
        ]);

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
