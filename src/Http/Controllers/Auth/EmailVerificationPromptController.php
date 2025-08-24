<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('AuthPackage::auth.verify-email');
    }
}
