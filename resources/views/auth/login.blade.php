@extends('AuthPackage::layouts.auth')

@section('title', 'Login')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Sign in to your account</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-input label="Email" name="email" type="email" value="{{ old('email') }}" required autofocus />

        <x-input label="Password" name="password" type="password" required />

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600" />
                <span class="text-sm">Remember me</span>
            </label>

            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">Forgot your
                password?</a>
        </div>

        <div>
            <x-button type="submit">Sign in</x-button>
        </div>
    </form>

    <p class="mt-4 text-sm">Don’t have an account? <a href="{{ route('register') }}"
            class="text-indigo-600 hover:underline">Register</a></p>
@endsection
