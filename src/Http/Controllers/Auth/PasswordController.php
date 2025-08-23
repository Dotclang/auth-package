<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Dotclang\AuthPackage\Http\Requests\SendResetLinkRequest;
use Dotclang\AuthPackage\Http\Requests\ResetPasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('AuthPackage::auth.forgot');
    }

    public function sendResetLinkEmail(SendResetLinkRequest $request)
    {
        $throttleKey = 'password-reset|' . Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            return back()->withErrors(['email' => ['Too many requests. Please try again later.']]);
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status !== Password::RESET_LINK_SENT) {
            RateLimiter::hit($throttleKey, 60);
        } else {
            RateLimiter::clear($throttleKey);
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token = null)
    {
        return view('AuthPackage::auth.reset')->with([
            'token' => $token,
            'email' => request()->email,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            // Fire the framework PasswordReset event
            event(new \Illuminate\Auth\Events\PasswordReset($user));

            Auth::login($user);
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
