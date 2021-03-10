<?php

namespace Marketplace\Foundation\Services;

use Illuminate\Support\Str;

class TokenService
{
    /**
     * Generate a token.
     *
     * @return string
     */
    public static function generateApiToken(): string
    {
        return Str::random(32);
    }
}
