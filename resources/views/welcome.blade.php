<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    {{-- Styles: use Vite when available, otherwise fall back to published assets --}}
    <link rel="stylesheet"
        href="{{ class_exists(\Illuminate\Support\Facades\Vite::class)
            ? Vite::asset('resources/css/app.css')
            : asset('vendor/Dotclang/auth-package/css/app.css') }}">
</head>

<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen container mx-auto px-4 py-8">
        <header class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ class_exists(\Illuminate\Support\Facades\Vite::class) ? Vite::asset('resources/img/logo.svg') : asset('vendor/Dotclang/auth-package/img/logo.svg') }}"
                        alt="Logo" class="h-10 w-10" />
                    <h1 class="text-xl font-semibold">AuthPackage</h1>
                </div>

                <nav class="space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">Sign in</a>
                        <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:underline">Dashboard</a>
                    @endguest
                </nav>
            </div>
        </header>

        <main>
            <section class="hero mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-4">Authentication scaffolding for your Laravel app</h2>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">A small, customizable auth package with views,
                            routes, and
                            controllers you can publish into your host application.</p>

                        <div class="flex gap-3">
                            <a href="{{ route('register') }}"
                                class="inline-block px-4 py-2 bg-indigo-600 text-white rounded">Get
                                started</a>
                            <a href="{{ route('login') }}" class="inline-block px-4 py-2 border rounded">Sign in</a>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <img src="{{ class_exists(\Illuminate\Support\Facades\Vite::class) ? Vite::asset('resources/img/office-illustration.svg') : asset('vendor/Dotclang/auth-package/img/office-illustration.svg') }}"
                            alt="Office" class="w-full h-auto" />
                    </div>
                </div>
            </section>

            <section class="features mb-12">
                <h3 class="text-2xl font-semibold mb-4">Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 border rounded bg-white dark:bg-gray-800">
                        <h4 class="font-semibold">Login & Registration</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Secure, ready-to-use forms and controllers.
                        </p>
                    </div>

                    <div class="p-4 border rounded bg-white dark:bg-gray-800">
                        <h4 class="font-semibold">Password Reset</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Email-based password reset flow included.
                        </p>
                    </div>

                    <div class="p-4 border rounded bg-white dark:bg-gray-800">
                        <h4 class="font-semibold">Email Verification</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Built-in email verification notifications
                            and views.</p>
                    </div>
                </div>
            </section>

            <section class="testimonials mb-12">
                <h3 class="text-2xl font-semibold mb-4">What users say</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 border rounded bg-white dark:bg-gray-800">
                        <p class="text-sm">"Simple and extensible — saved me hours of setup."</p>
                        <p class="mt-2 text-xs text-gray-500">— Jane Doe</p>
                    </div>

                    <div class="p-4 border rounded bg-white dark:bg-gray-800">
                        <p class="text-sm">"Clean views and straightforward controllers."</p>
                        <p class="mt-2 text-xs text-gray-500">— John Smith</p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="text-center text-sm text-gray-500">
            © {{ date('Y') }} AuthPackage — dotclang
        </footer>
    </div>

    {{-- Scripts: Vite or published fallback --}}
    <script
        src="{{ class_exists(\Illuminate\Support\Facades\Vite::class)
            ? Vite::asset('resources/js/app.js')
            : asset('vendor/Dotclang/auth-package/js/app.js') }}"
        defer></script>
</body>

</html>
