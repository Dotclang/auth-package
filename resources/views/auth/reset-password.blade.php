@extends('AuthPackage::layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
        <h2 class="text-2xl font-semibold mb-4">Set a new password</h2>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? '' }}" />

            <x-input label="Email" name="email" type="email" value="{{ $email ?? old('email') }}" required />

            <x-input label="New password" name="password" type="password" required />

            <x-input label="Confirm password" name="password_confirmation" type="password" required />

            <div>
                <x-button type="submit">Reset password</x-button>
            </div>
        </form>
    </div>
@endsection
