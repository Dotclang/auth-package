@extends('layouts.app')

@section('content')
<div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>

    <form method="POST" action="{{ url('auth/login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   required>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
            Login
        </button>
    </form>
</div>
@endsection
