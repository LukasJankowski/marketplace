<?php

namespace Marketplace\Core\Auth\Check;

use Marketplace\Core\Auth\Login\LoginResource;
use Marketplace\Core\User\User;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Logging\Logger;

class CheckLoginAction extends BaseAction
{
    /**
     * CheckLoginAction constructor.
     *
     * @param Logger $logger
     */
    public function __construct(private Logger $logger)
    {
    }

    /**
     * Check for login status.
     *
     * @param User $user
     *
     * @return LoginResource
     */
    public function run(User $user): LoginResource
    {
        $this->logger->info('Successful auth check', ['causer' => $user->getAuthIdentifier()]);

        return $this->respond(LoginResource::class, $user);
    }
}
