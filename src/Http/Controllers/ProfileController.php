<?php

namespace Dotclang\AuthPackage\Http\Controllers;

use Dotclang\AuthPackage\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the user's profile page.
     */
    public function show(Request $request): View
    {
        return view('AuthPackage::auth.profile');
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var \Dotclang\AuthPackage\Models\User $user */
        $user = $request->user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('profile')->with('status', 'Profile updated.');
    }
}
