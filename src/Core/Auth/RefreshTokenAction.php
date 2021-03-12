<?php

namespace Marketplace\Core\Auth;

use Marketplace\Core\User\User;
use Illuminate\Http\Request;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\Api\TokenService;

class RefreshTokenAction
{
    /**
     * RefreshTokenAction constructor.
     *
     * @param Request $request
     * @param Logger $logger
     */
    public function __construct(
        private Request $request,
        private Logger $logger
    ) {}

    /**
     * Refresh the users API token.
     *
     * @param null|User $user
     *
     * @return User
     */
    public function run(?User $user = null): User
    {
        // This action may only be run in an authenticated context or
        // when it can be ensured that a valid User model is passed.
        if ($user === null) {
            $user = $this->request->user() ?? throw new \LogicException(
                sprintf(
                    'TokenRefresh on unauthenticated user. From: %s',
                    $this->request->ip()
                )
            );
        }

        $user->setAttribute('api_token', TokenService::generateApiToken($user->getAuthIdentifier()));
        $user->save();

        $this->logger->info('Refreshed API token', ['affected' => $user->getAuthIdentifier()]);

        return $user->fresh();
    }
}
