<?php

namespace Marketplace\Core\Authentication\Actions;

use Marketplace\Core\Authentication\Resources\LoginResource;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\User;
use Marketplace\Foundation\Actions\BaseAction;

class CheckLoginAction extends BaseAction
{
    /**
     * CheckLoginAction constructor.
     */
    public function __construct(private Logger $logger)
    {
    }

    /**
     * Check for login status.
     */
    public function run(User $user): LoginResource
    {
        $this->logger->info('Successful auth check', ['causer' => $user->getAuthIdentifier()]);

        return $this->respond(LoginResource::class, $user);
    }
}
