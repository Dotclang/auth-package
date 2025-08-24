<?php

namespace Dotclang\AuthPackage\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('AuthPackage::dashboard.index');
    }
}
