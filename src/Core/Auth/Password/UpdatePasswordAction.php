<?php

namespace Marketplace\Core\Auth\Password;

use Marketplace\Core\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\User\UserService;

class UpdatePasswordAction
{
    /**
     * UpdatePasswordAction constructor.
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
     * Update the password.
     *
     * @param CredentialsDto $creds
     *
     * @return User
     */
    public function run(CredentialsDto $creds): User
    {
        try {
            return $this->updatePassword($creds);
        } catch (ModelNotFoundException $e) {
            $this->logger->info('Failed to find user to update password.', [
                'route_id' => $this->request->route('id')
            ]);

            throw new UpdatePasswordException(previous: $e);
        }
    }

    /**
     * Update the users password.
     *
     * @param CredentialsDto $creds
     *
     * @return User
     */
    private function updatePassword(CredentialsDto $creds): User
    {
        $user = $this->userService->updatePasswordOfUser(
            $this->request->route('id'),
            $creds->getPassword()
        );

        $this->logger->info('Updated password of user.', ['user' => $user->getAuthIdentifier()]);

        return $user;
    }
}
