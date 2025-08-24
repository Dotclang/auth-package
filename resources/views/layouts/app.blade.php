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
    @include('AuthPackage::layouts.partials.header')

    <div class="min-h-screen flex">
        @include('AuthPackage::layouts.partials.sidebar')

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
    </div>

    @include('AuthPackage::layouts.partials.footer')
</body>

</html>
