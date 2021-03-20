<?php

namespace Marketplace\Core\Auth\Login;

use Marketplace\Core\Auth\Refresh\RefreshTokenAction;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Logging\Logger;

class LoginUserAction extends BaseAction
{
    /**
     * LoginUserAction constructor.
     *
     * @param RefreshTokenAction $refreshToken
     * @param UserService $service
     * @param Logger $logger
     */
    public function __construct(
        private RefreshTokenAction $refreshToken,
        private UserService $service,
        private Logger $logger
    )
    {
    }

    /**
     * Attempt to login the user.
     *
     * @param CredentialsDto $creds
     *
     * @return LoginResource
     *
     * @throws LoginException
     */
    public function run(CredentialsDto $creds): LoginResource
    {
        $user = $this->service->getUserByCredentials($creds);

        if ($this->checkLogin($creds, $user)) {
            return $this->refreshToken->run($user);
        }

        $this->logger->info(
            'Failed login attempt',
            [
                'email' => $creds->getEmail(),
                'role' => $creds->getRole()->getRole(),
            ]
        );

        throw new LoginException();
    }

    /**
     * Check if the credentials are valid.
     *
     * @param CredentialsDto $creds
     * @param User|null $user
     *
     * @return bool
     */
    private function checkLogin(CredentialsDto $creds, null|User $user): bool
    {
        if ($user && $creds->getPassword()->verify($user->getAuthPassword())) {
            $this->logger->info(
                'Successful login attempt',
                [
                    'causer' => $user->getAuthIdentifier(),
                ]
            );

            UserLoggedIn::dispatch($user);

            return true;
        }

        return false;
    }
}
