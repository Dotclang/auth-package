<?php

namespace Dotclang\AuthPackage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequirePasswordConfirmed
{
    /**
     * Handle an incoming request and ensure password was recently confirmed.
     *
     * @param  int|null  $timeout
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $timeout = null)
    {
        $timeout = is_null($timeout)
            ? config('auth.password_timeout', 10800)
            : (int) $timeout;

        $confirmedAt = (int) $request->session()->get('auth.password_confirmed_at', 0);

        if ($confirmedAt + $timeout < time()) {
            // Not confirmed recently — redirect to confirm page
            return redirect()->route('auth.password.confirm');
        }

        return $next($request);
    }
}
