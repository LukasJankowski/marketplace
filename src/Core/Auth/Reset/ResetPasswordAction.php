<?php

namespace Marketplace\Core\Auth\Reset;

use Marketplace\Core\User\User;
use Illuminate\Http\Request;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Foundation\Exceptions\ValidationException;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\Type\TypeService;
use Marketplace\Core\User\UserService;

class ResetPasswordAction
{
    /**
     * ResetPasswordAction constructor.
     *
     * @param Logger $logger
     * @param Request $request
     * @param UserService $userService
     */
    public function __construct(
        private Logger $logger,
        private Request $request,
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
        $user = $this->userService->getUserByCredentials($creds);

        if ($user === null) {
            $this->logger->info('Reset password failed.', [
                'email' => $creds->getEmail(),
                'type' => TypeService::getKeyByClass($creds->getType())
            ]);

            throw ValidationException::withMessages([
                'email' => 'marketplace.core.auth.reset.invalid'
            ]);
        }

        $this->userService->sendPasswordResetEmailToUser($user);

        $this->logger->info('Reset password sent.', [
            'email' => $creds->getEmail(),
            'type' => TypeService::getKeyByClass($creds->getType())
        ]);

        return $user;
    }
}
