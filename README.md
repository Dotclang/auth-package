README

AuthPackage provides authentication views, controllers and routes for Laravel (login, register, password reset) using Tailwind-styled Blade templates.

Installation

1) Require the package from Packagist:

```bash
composer require dotclang/auth-package
```

Package on Packagist: https://packagist.org/packages/dotclang/auth-package

2) If your app does not auto-discover the provider, register the service provider in `config/app.php` providers array:

```php
Dotclang\AuthPackage\AuthServiceProvider::class,
```

Publishing files

You can publish individual parts of the package using `vendor:publish` with the provider and tag.

- Publish configuration (merged into `config('auth')`):

```bash
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="auth-config"
```

- Publish views (into `resources/views/vendor/auth-package`):

```bash
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="views"
```

- Publish controllers (into `app/Http/Controllers/AuthPackage`):

```bash
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="controllers"
```

- Publish routes (copies package `routes/*.php` into your app `routes/`):

```bash
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="routes"
```

- Publish front-end assets (optional):

```bash
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="assets"
```

Install command (convenience)

The package provides a convenience installer command that publishes config, views, controllers and routes, and optionally assets. Usage:

```bash
php artisan authpackage:install
```

Flags:

- `--assets` — publish front-end assets non-interactively
- `--force` — overwrite any previously published files

Example (publish everything including assets, force overwrite):

```bash
php artisan authpackage:install --assets --force
```

Notes

- The package merges `config/auth.php` into your app `auth` config so `config('auth.password_timeout')` will be available.
- Views are loaded under the `auth-package::` namespace; after publishing you can edit the views in `resources/views/vendor/auth-package`.
