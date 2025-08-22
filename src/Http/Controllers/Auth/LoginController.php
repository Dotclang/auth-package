<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Dotclang\AuthPackage\Http\Requests\LoginRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('AuthPackage::auth.login');
    }

    public function login(LoginRequest $request)
    {
        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in '.RateLimiter::availableIn($throttleKey).' seconds.'],
            ]);
        }

        $credentials = $request->only('email', 'password');
        $attemptRemember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $attemptRemember)) {
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
