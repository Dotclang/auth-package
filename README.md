# AuthPackage

This package provides authentication views and routes for Laravel (login, register, password reset) using Tailwind-styled blade templates.

## Notes

- The package publishes a small config (`config/auth.php`) which exposes `password_timeout`. To publish it run:

```bash
# Install package
composer require dotclang/auth-package
```

```bash
# Publish package configuration only
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="auth-config"
```

Or publish views and config together with:

```bash
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="views"
php artisan vendor:publish --provider="Dotclang\\AuthPackage\\AuthServiceProvider" --tag="auth-config"
```

Note: the package merges its `config/auth.php` into your application's `auth` config so the `password_timeout` setting is available as `config('auth.password_timeout')`.

## Install command

This package ships with a convenience command to publish views and configuration and to show Tailwind setup notes. To run it:

```bash
php artisan authpackage:install
```

Pass `--force` to overwrite previously published files.
