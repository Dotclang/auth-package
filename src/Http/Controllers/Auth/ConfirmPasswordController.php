<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Dotclang\AuthPackage\Http\Requests\ConfirmPasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash as FacadesHash;

class ConfirmPasswordController extends Controller
{
    public function showConfirmPassword()
    {
        return view('AuthPackage::auth.confirm');
    }

    public function confirmPassword(ConfirmPasswordRequest $request)
    {
        $user = $request->user();

        if (! FacadesHash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended('/');
    }
}
