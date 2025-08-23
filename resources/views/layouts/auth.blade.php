<!doctype html>
<html lang="en" class="antialiased">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dotclang — Dashboard</title>
    <!-- Consumers should include Tailwind and their own CSS when publishing -->
    @if (class_exists(\Illuminate\Support\Facades\Vite::class))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    @include('AuthPackage::components.header')

    <div class="max-w-6xl mx-auto px-4 py-8 lg:flex lg:gap-6">
        <aside id="sidebar" class="hidden lg:block w-64">
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-md p-4">
                <div class="text-sm font-medium">Account</div>
                <nav class="mt-4 flex flex-col gap-2 text-sm">
                    <a href="{{ route('dashboard') }}" class="block text-gray-700 dark:text-gray-200">Dashboard</a>
                    <a href="#" class="block text-gray-700 dark:text-gray-200">Profile</a>
                    <a href="#" class="block text-gray-700 dark:text-gray-200">Settings</a>
                </nav>
            </div>
        </aside>

        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    @include('AuthPackage::components.footer')
</body>

</html>
