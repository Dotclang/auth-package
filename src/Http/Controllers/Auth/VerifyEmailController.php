<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{
    /**
     * Handle the email verification process.
     *
     * @param  int  $id
     * @param  string  $hash
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        /** @var \Dotclang\AuthPackage\Models\User|null $user */
        $user = $request->user();
        if (! $user || (int) $user->getKey() !== (int) $id) {
            abort(403);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect()->route('dashboard');
    }
}
