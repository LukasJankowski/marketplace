<?php

namespace Marketplace\Core\Authentication\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\Authentication\Exceptions\UserVerificationException;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Actions\ReadUserAction;
use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class VerifyUserAction extends BaseAction
{
    /**
     * VerifyUserAction constructor.
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
     * Verify the users email.
     *
     * @param string|int $id
     *
     * @return UserResource
     */
    public function run(string|int $id): UserResource
    {
        try {
            return $this->verifyUser($id);
        } catch (ModelNotFoundException $e) {
            $this->logger->info(
                'Failed to find user to verify.',
                [
                    'route_id' => $id,
                ]
            );

            throw new UserVerificationException(previous: $e);
        }
    }

    /**
     * Verify the users email.
     *
     * @param string|int $id
     *
     * @return UserResource
     */
    private function verifyUser(string|int $id): UserResource
    {
        $this->userService->markUserVerified($id);

        $this->logger->info('Verified user.', ['user' => $id]);

        return $this->action->run($id);
    }
}
