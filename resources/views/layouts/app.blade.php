<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Auth Package') }}</title>
    @vite('resources/css/app.css') {{-- Laravel Vite/Tailwind --}}
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center">
        @yield('content')
    </div>
</body>
</html>
