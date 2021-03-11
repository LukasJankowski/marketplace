<?php

namespace Marketplace\Foundation\Guards;

use App\Models\User;
use Illuminate\Auth\TokenGuard as IlluminateTokenGuard;
use Illuminate\Contracts\Auth\Guard;
use Marketplace\Foundation\Services\TokenService;

class TokenGuard extends IlluminateTokenGuard implements Guard
{
    /**
     * @inheritDoc
     */
    public function user(): ?\Illuminate\Contracts\Auth\Authenticatable
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
