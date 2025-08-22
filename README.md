# AuthPackage

This package provides authentication views and routes for Laravel (login, register, password reset) using Tailwind-styled blade templates.

## Routes

The package registers routes under the `/auth/*` prefix and uses the `auth.` route name prefix. Main routes:

- auth.login (GET) -> /auth/login
- auth.login.attempt (POST) -> /auth/login
- auth.register (GET) -> /auth/register
- auth.register.attempt (POST) -> /auth/register
- auth.password.request (GET) -> /auth/password/reset
- auth.password.email (POST) -> /auth/password/email (throttled)
- auth.password.reset (GET) -> /auth/password/reset/{token}
- auth.password.update (POST) -> /auth/password/reset
- auth.logout (POST) -> /auth/logout

Compatibility redirects are provided for common unprefixed routes like `/login` and `/register` which redirect to the package endpoints.

## Views

Views are published under the `AuthPackage::auth.*` namespace. They are located at `resources/views/auth/` in the package.

## Notes

- Ensure mail is configured in the host app for password reset emails.
- If you want the package routes to be available at the root (`/login`), the compatibility redirects are provided. Alternatively, you can publish and modify routes in your app.
- Run `php artisan vendor:publish --tag=config` if you publish package config.

## Next steps

- Add tests and optional email templates.
- Add customization options for route prefixes and middleware.
