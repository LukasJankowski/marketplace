<?php

namespace Marketplace\Foundation\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Marketplace\Foundation\Exceptions\AuthenticationException;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user() === null) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
