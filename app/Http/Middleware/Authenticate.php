<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guard = $guards[0] ?? null; // Use the first guard as the default

        if (Auth::guard($guard)->guest()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        return $next($request);
    }
    
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login'); // This line should work now
        }
    }
}
