<?php

namespace Marketplace\Core\Api;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use RuntimeException;

class TokenService
{
    public const SECRET_KEY = 'APP_SECRET';

    public const TOKEN_DIVIDER = '.';

    /**
     * Generate a token.
     */
    public static function generateApiToken(int|string $userId): string
    {
        return self::makeToken(time(), $userId, self::getSecret());
    }

    /**
     * Generate the token consistently.
     */
    private static function makeToken(int|string $time, int|string $userId, string $secret): string
    {
        return $time . self::TOKEN_DIVIDER . md5($time . $userId . $secret);
    }

    /**
     * Get the app secret.
     */
    private static function getSecret(): string
    {
        $secret = Env::get(self::SECRET_KEY, false);

        if ($secret === false) {
            throw new RuntimeException(
                sprintf('No %s has been specified.', self::SECRET_KEY)
            );
        }

        return $secret;
    }

    /**
     * Check if its a valid token.
     */
    public static function isValidToken(string $token, int|string $userId): bool
    {
        $replicatedToken = self::makeToken(
            Str::before($token, self::TOKEN_DIVIDER),
            $userId,
            self::getSecret()
        );

        return hash_equals($token, $replicatedToken)
            && !self::isTokenExpired($token);
    }

    /**
     * Check if the token is expired.
     */
    private static function isTokenExpired(string $token): bool
    {
        $lifespan = (int) Config::get('marketplace.core.authentication.lifetime', 120);
        $tokenIssueTimestamp = (int) Str::before($token, self::TOKEN_DIVIDER);

        return time() > $tokenIssueTimestamp + ($lifespan * 60);
    }
}
