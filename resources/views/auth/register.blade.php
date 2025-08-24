@extends('AuthPackage::layouts.app')

@section('title', 'Register')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Create an account</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <x-input label="Full name" name="name" value="{{ old('name') }}" required />

        <x-input label="Email" name="email" type="email" value="{{ old('email') }}" required />

        <x-input label="Password" name="password" type="password" required />

        <x-input label="Confirm password" name="password_confirmation" type="password" required />

        <div>
            <x-button type="submit">Create account</x-button>
        </div>
    </form>

    <p class="mt-4 text-sm">Already have an account? <a href="{{ route('login') }}"
            class="text-indigo-600 hover:underline">Sign in</a></p>
@endsection
