<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'AuthPackage')</title>
    {{-- Small inline script to install initial theme before CSS loads (prevents flash) --}}
    @if (class_exists(\Illuminate\Support\Facades\Vite::class))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex">
        @include('AuthPackage::layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-h-screen">
            @include('AuthPackage::layouts.partials.header')

            <main class="flex-1 p-6">
                <div class="max-w-6xl mx-auto">
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
            </main>

            @include('AuthPackage::layouts.partials.footer')
        </div>
</body>

</html>
