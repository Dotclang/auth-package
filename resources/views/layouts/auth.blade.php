<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'AuthPackage')</title>
    @if (class_exists(\Illuminate\Support\Facades\Vite::class))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-center p-6 sm:p-12">
        <div
            class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 md:p-10">
                <div class="flex items-center justify-center mb-6">
                    <img src="{{ class_exists(\Illuminate\Support\Facades\Vite::class) ? Vite::asset('resources/img/logo.svg') : asset('vendor/Dotclang/auth-package/img/logo.svg') }}"
                        alt="AuthPackage" class="h-12 w-12" />
                </div>

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>

            <div class="hidden md:flex items-center justify-center bg-indigo-50 dark:bg-gray-700 p-6">
                <img src="{{ class_exists(\Illuminate\Support\Facades\Vite::class) ? Vite::asset('resources/img/auth-illustration.svg') : asset('vendor/Dotclang/auth-package/img/auth-illustration.svg') }}"
                    alt="Illustration" class="max-h-64 w-auto" />
            </div>
        </div>
    </div>
</body>

</html>
