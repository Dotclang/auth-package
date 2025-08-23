<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Dotclang\AuthPackage\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin(): View
    {
        return view('AuthPackage::auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw \Illuminate\Validation\ValidationException::withMessages(['email' => ['Too many login attempts. Please try again in '.RateLimiter::availableIn($throttleKey).' seconds.']]);
        }

        $credentials = $request->only('email', 'password');
        $attemptRemember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $attemptRemember)) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
