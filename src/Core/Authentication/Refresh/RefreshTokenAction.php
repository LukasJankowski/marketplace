<?php

namespace Marketplace\Core\Authentication\Refresh;

use Marketplace\Core\Api\TokenService;
use Marketplace\Core\Authentication\Login\LoginResource;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\User;
use Marketplace\Foundation\Actions\BaseAction;

class RefreshTokenAction extends BaseAction
{
    /**
     * RefreshTokenAction constructor.
     *
     * @param Logger $logger
     */
    public function __construct(private Logger $logger)
    {
    }

    /**
     * Refresh the users API token.
     *
     * @param User $user
     *
     * @return LoginResource
     */
    public function run(User $user): LoginResource
    {
        $user->setAttribute('api_token', TokenService::generateApiToken($user->getAuthIdentifier()));
        $user->save();

        $this->logger->info('Refreshed API token', ['affected' => $user->getAuthIdentifier()]);

        return $this->respond(LoginResource::class, $user->fresh());
    }
}
