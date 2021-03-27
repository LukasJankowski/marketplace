<?php

namespace Marketplace\Core\Authentication\Actions;

use Marketplace\Core\Authentication\Resources\ResetResource;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Exceptions\ValidationException;

class ResetPasswordAction extends BaseAction
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
    )
    {
    }

    /**
     * Send the password reset notification.
     *
     * @param CredentialsDto $creds
     *
     * @return ResetResource
     *
     * @throws ValidationException
     */
    public function run(CredentialsDto $creds): ResetResource
    {
        $user = $this->fetchUser($creds);

        $this->userService->sendPasswordResetEmailToUser($user);

        $this->logger->info(
            'Reset password sent.',
            [
                'email' => $creds->getEmail(),
                'role' => $creds->getRole(),
            ]
        );

        return $this->respond(ResetResource::class, $user);
    }

    /**
     * Fetch the associated user.
     *
     * @param CredentialsDto $creds
     *
     * @return User
     *
     * @throws ValidationException
     */
    private function fetchUser(CredentialsDto $creds): User
    {
        $user = $this->userService->getUserByCredentials($creds);

        if ($user === null) {
            $this->logger->info(
                'Reset password failed.',
                [
                    'email' => $creds->getEmail(),
                    'role' => $creds->getRole(),
                ]
            );

            throw ValidationException::withMessages(
                [
                    'email' => 'marketplace.core.authentication.reset.invalid',
                ]
            );
        }

        return $user;
    }
}
