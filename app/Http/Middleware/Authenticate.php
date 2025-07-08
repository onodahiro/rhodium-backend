<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Authenticate
{
    public function handle($request, Closure $next, ...$guards) {
        if (!auth()->guard(...$guards)->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
         return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
