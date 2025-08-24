<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        /** @var \Dotclang\AuthPackage\Models\User $user */
        $user = $request->user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::logoutOtherDevices($request->input('password'));

        return back()->with('status', 'password.updated');
    }
}
