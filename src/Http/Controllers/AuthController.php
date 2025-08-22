<?php

namespace Dotclang\AuthPackage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends BaseController
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
        return redirect()->intended('/');
    }

    public function showRegister()
    {
        return view('authpackage::auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
