<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Auth Package') }}</title>
    @if (class_exists(\Illuminate\Support\Facades\Vite::class))
        @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Laravel Vite --}}
    @else
        <!-- Vite not available in this host app; include your own CSS/JS -->
    @endif
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen w-full flex items-center justify-center">
        @yield('content')
    </div>
</body>

</html>
