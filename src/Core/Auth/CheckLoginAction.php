<?php

namespace Marketplace\Core\Auth;

use Marketplace\Core\User\User;
use Illuminate\Http\Request;
use Marketplace\Core\Auth\Login\LoginException;
use Marketplace\Foundation\Logging\Logger;

class CheckLoginAction
{
    /**
     * CheckLoginAction constructor.
     *
     * @param Logger $logger
     * @param Request $request
     */
    public function __construct(
        private Logger $logger,
        private Request $request
    ) {}

    /**
     * Check for login status.
     *
     * @return User
     *
     * @throws LoginException
     */
    public function run(): User
    {
        /** @var User|null $user */
        $user = $this->request->user();

        if ($user) {
            $this->logger->info('Successful auth check', ['causer' => $user->getAuthIdentifier()]);

            return $user;
        }

        $this->logger->info('Failed auth check');

        throw new LoginException();
    }
}
