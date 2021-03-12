<?php

namespace Marketplace\Core\Auth\Reset;

use Marketplace\Core\User\User;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Foundation\Exceptions\ValidationException;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\User\UserService;

class ResetPasswordAction
{
    /**
     * ResetPasswordAction constructor.
     *
     * @param Logger $logger
     * @param UserService $userService
     */
    public function __construct(
        private Logger $logger,
        private UserService $userService,
    ) {}

    /**
     * Send the password reset notification.
     *
     * @param CredentialsDto $creds
     *
     * @return User
     *
     * @throws ValidationException
     */
    public function run(CredentialsDto $creds): User
    {
        $user = $this->fetchUser($creds);

        $this->userService->sendPasswordResetEmailToUser($user);

        $this->logger->info('Reset password sent.', [
            'email' => $creds->getEmail(),
            'type' => $creds->getType()->getClass()
        ]);

        return $user;
    }

    /**
     * Fetch the associated user.
     *
     * @param CredentialsDto $creds
     * @return User
     *
     * @throws ValidationException
     */
    private function fetchUser(CredentialsDto $creds): User
    {
        $user = $this->userService->getUserByCredentials($creds);

        if ($user === null) {
            $this->logger->info('Reset password failed.', [
                'email' => $creds->getEmail(),
                'type' => $creds->getType()->getClass()
            ]);

            throw ValidationException::withMessages([
                'email' => 'marketplace.core.auth.reset.invalid'
            ]);
        }

        return $user;
    }
}
