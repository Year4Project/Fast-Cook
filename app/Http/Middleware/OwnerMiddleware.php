<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if (auth()->check()) {
        if (auth()->user()->user_type == 2) {
            return $next($request);
        } else {
            auth()->logout();
            return redirect(url('/'));
        }
    } else {
        auth()->logout();
        return redirect(url('/'));
    }
}

}
