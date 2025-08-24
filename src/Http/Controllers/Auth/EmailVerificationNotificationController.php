<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        /** @var \Dotclang\AuthPackage\Models\User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return back();
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
