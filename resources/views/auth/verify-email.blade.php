@extends('AuthPackage::layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
        <h2 class="text-2xl font-semibold mb-4">Verify your email</h2>

        <p class="text-sm mb-4">Thanks for signing up! Before getting started, could you verify your email address by
            clicking the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

        @if (session('status') === 'verification-link-sent')
            <div class="text-sm text-green-600 mb-3">A new verification link has been sent to your email address.</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-button type="submit">Resend verification email</x-button>
        </form>
    </div>
@endsection
