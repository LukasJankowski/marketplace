<?php

namespace Marketplace\Core\Authentication\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\Authentication\Exceptions\UpdatePasswordException;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Actions\ReadUserAction;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class UpdatePasswordAction extends BaseAction
{
    /**
     * UpdatePasswordAction constructor.
     *
     * @param Logger $logger
     * @param UserService $userService
     * @param ReadUserAction $action
     */
    public function __construct(
        private Logger $logger,
        private UserService $userService,
        private ReadUserAction $action,
    )
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
            return $this->updatePassword($creds, $id);
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
     * @return UserResource
     */
    private function updatePassword(CredentialsDto $creds, string|int $id): UserResource
    {
        $this->userService->updatePasswordOfUser($id, $creds->getPassword());

        $this->logger->info('Updated password of user.', ['user' => $id]);

        return $this->action->run($id);
    }
}
