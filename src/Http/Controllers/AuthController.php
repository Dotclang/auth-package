<?php

namespace Dotclang\AuthPackage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('AuthPackage::auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in '.$this->secondsRemaining($throttleKey).' seconds.'],
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function showRegister()
    {
        return view('AuthPackage::auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userModel = app('config')->get('auth.providers.users.model', 'App\\Models\\User');

        $user = $userModel::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Fire the registered event (uses listeners such as email verification)
        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    // Forgot password / reset
    public function showForgotPassword()
    {
        return view('AuthPackage::auth.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('AuthPackage::auth.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) use ($request) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new Registered($user));

            Auth::login($user);
        });

    return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Helper to get remaining seconds for throttle.
     */
    protected function secondsRemaining(string $key): int
    {
        $availableAt = RateLimiter::availableIn($key);

        return $availableAt;
    }
}
