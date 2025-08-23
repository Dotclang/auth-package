@extends('AuthPackage::layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <p>Welcome, {{ auth()->user() ? auth()->user()->name : 'User' }}!</p>

    <div class="mt-6">
        <a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-red-600">Logout</a>
        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
</div>
@endsection
