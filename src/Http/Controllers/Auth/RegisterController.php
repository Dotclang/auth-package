<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Dotclang\AuthPackage\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegister(): View
    {
        return view('AuthPackage::auth.register');
    }

    /**
     * Handle the incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model&\Illuminate\Contracts\Auth\Authenticatable> $userModel */
        $userModel = app('config')->get('auth.providers.users.model', 'App\\Models\\User');

        if (! class_exists($userModel)) {
            // Fallback to the default User model if configured model is not present.
            $userModel = 'App\\Models\\User';
        }

        /** @var \Illuminate\Database\Eloquent\Model&\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = $userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
