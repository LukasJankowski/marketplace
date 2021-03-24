<?php

namespace Marketplace\Foundation\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Marketplace\Foundation\Exceptions\AuthorizationException;

class TokenMiddleware
{
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user() === null) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
