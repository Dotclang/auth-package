@extends('AuthPackage::layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow max-w-2xl">
        <h1 class="text-2xl font-semibold">Profile</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Update your account information.</p>

        @if (session('status'))
            <div class="mt-4 p-3 bg-green-50 dark:bg-green-900 text-green-800 rounded">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mt-4 p-3 bg-red-50 dark:bg-red-900 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input name="name" type="text" value="{{ old('name', auth()->user()?->name) }}"
                    class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none @error('name') border-red-500 dark:border-red-400 @else dark:border-gray-700 @enderror" />
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input name="email" type="email" value="{{ old('email', auth()->user()?->email) }}"
                    class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none @error('email') border-red-500 dark:border-red-400 @else dark:border-gray-700 @enderror" />
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">New Password (optional)</label>
                <input name="password" type="password"
                    class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none @error('password') border-red-500 dark:border-red-400 @else dark:border-gray-700 @enderror" />
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Confirm Password</label>
                <input name="password_confirmation" type="password"
                    class="mt-1 block w-full px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-900 text-sm focus:outline-none @error('password_confirmation') border-red-500 dark:border-red-400 @else dark:border-gray-700 @enderror" />
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-300">Cancel</a>
            </div>
        </form>
    </div>
@endsection
