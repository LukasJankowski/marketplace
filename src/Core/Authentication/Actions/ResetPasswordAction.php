<?php

namespace Marketplace\Core\Authentication\Actions;

use Marketplace\Core\Authentication\Resources\ResetResource;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Exceptions\ValidationException;

class ResetPasswordAction extends BaseAction
{
    /**
     * ResetPasswordAction constructor.
     */
    public function __construct(
        private Logger $logger,
        private UserService $userService,
    ) {
    }

    /**
     * Send the password reset notification.
     *
     * @throws ValidationException
     */
    public function run(UserDto $userDto): ResetResource
    {
        $user = $this->fetchUser($userDto);

        $this->userService->sendPasswordResetEmailToUser($user);

        $this->logger->info(
            'Reset password sent.',
            [
                'email' => $userDto->email,
                'role' => $userDto->role,
            ]
        );

        return $this->respond(ResetResource::class, $user);
    }

    /**
     * Fetch the associated user.
     *
     * @throws ValidationException
     */
    private function fetchUser(UserDto $userDto): User
    {
        $user = $this->userService->getUserByCredentials($userDto);

        if ($user === null) {
            $this->logger->info(
                'Reset password failed.',
                [
                    'email' => $userDto->email,
                    'role' => $userDto->role,
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
