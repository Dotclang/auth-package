<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Dotclang\AuthPackage\Http\Requests\RegisterRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('AuthPackage::auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $userModel = app('config')->get('auth.providers.users.model', 'App\\Models\\User');

        $user = $userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
