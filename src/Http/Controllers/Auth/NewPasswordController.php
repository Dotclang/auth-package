<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Show the password reset form.
     *
     * @param  string|null  $token
     */
    public function create(Request $request, $token = null): View
    {
        return view('AuthPackage::auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('dashboard')
                    : back()->withErrors(['email' => Lang::get($status)]);
    }
}
