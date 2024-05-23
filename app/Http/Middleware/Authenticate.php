<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // public function handle($request, Closure $next, ...$guards)
    // {
    //     if (!$request->user()) {
    //         return redirect()->route('login');
    //     }
    //     if (!$request->user() || ($request->user() && !$request->user()->email_verified_at || !$request->user()->password)) {
    //         return redirect()->route('partenaires.verify');
    //     }

    //     return $next($request);
    // }
}
