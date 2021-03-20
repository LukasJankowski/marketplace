<?php

namespace Marketplace\Foundation\Guards;

use Illuminate\Auth\TokenGuard as IlluminateTokenGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Marketplace\Core\Api\TokenService;
use Marketplace\Core\User\User;

class TokenGuard extends IlluminateTokenGuard implements Guard
{
    /**
     * @inheritDoc
     */
    public function user(): ?Authenticatable
    {
        /** @var User $user */
        $user = parent::user();

        return $user !== null && TokenService::isValidToken(
            $user->getAttribute('api_token'),
            $user->getAuthIdentifier()
        )
            ? $user
            : $this->user = null;
    }
}
