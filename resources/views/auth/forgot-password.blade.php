@extends('AuthPackage::layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
        <h2 class="text-2xl font-semibold mb-4">Reset your password</h2>

        @if (session('status'))
            <div class="text-sm text-green-600 mb-3">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <x-input label="Email" name="email" type="email" required />

            <div>
                <x-button type="submit">Send reset link</x-button>
            </div>
        </form>

        <p class="mt-4 text-sm"><a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Back to login</a></p>
    </div>
@endsection
