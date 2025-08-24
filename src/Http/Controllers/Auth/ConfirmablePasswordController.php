<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    public function show(): View
    {
        return view('AuthPackage::auth.confirm-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required']]);

        /** @var \Dotclang\AuthPackage\Models\User $user */
        $user = $request->user();

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        // Password confirmed — redirect to intended location
        return redirect()->intended('/');
    }
}
