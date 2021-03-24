<?php

namespace Marketplace\Core\Auth\Password;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class UpdatePasswordAction extends BaseAction
{
    /**
     * UpdatePasswordAction constructor.
     *
     * @param Logger $logger
     * @param UserService $userService
     */
    public function __construct(private Logger $logger, private UserService $userService)
    {
    }

    /**
     * Update the password.
     *
     * @param CredentialsDto $creds
     * @param string|int $id
     *
     * @return UserResource
     */
    public function run(CredentialsDto $creds, string|int $id): UserResource
    {
        try {
            return $this->respond(UserResource::class, $this->updatePassword($creds, $id));
        } catch (ModelNotFoundException $e) {
            $this->logger->info(
                'Failed to find user to update password.',
                [
                    'route_id' => $id,
                ]
            );

            throw new UpdatePasswordException(previous: $e);
        }
    }

    /**
     * Update the users password.
     *
     * @param CredentialsDto $creds
     * @param string|int $id
     *
     * @return User
     */
    private function updatePassword(CredentialsDto $creds, string|int $id): User
    {
        $user = $this->userService->updatePasswordOfUser($id, $creds->getPassword());

        $this->logger->info('Updated password of user.', ['user' => $user->getAuthIdentifier()]);

        return $user;
    }
}
