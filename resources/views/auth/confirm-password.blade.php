@extends('AuthPackage::layouts.app')

@section('title', 'Confirm Password')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
        <h2 class="text-2xl font-semibold mb-4">Confirm your password</h2>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <x-input label="Password" name="password" type="password" required />

            <div>
                <x-button type="submit">Confirm</x-button>
            </div>
        </form>
    </div>
@endsection
