<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('AuthPackage::auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', Lang::get($status))
                    : back()->withErrors(['email' => Lang::get($status)]);
    }
}
