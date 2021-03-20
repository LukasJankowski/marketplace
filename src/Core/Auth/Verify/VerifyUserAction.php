<?php

namespace Marketplace\Core\Auth\Verify;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Logging\Logger;

class VerifyUserAction extends BaseAction
{
    /**
     * VerifyUserAction constructor.
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
     * Verify the users email.
     *
     * @param string|int $id
     *
     * @return UserResource
     */
    public function run(string|int $id): UserResource
    {
        try {
            return $this->respond(UserResource::class, $this->verifyUser($id));
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
     * @return User
     */
    private function verifyUser(string|int $id): User
    {
        $user = $this->userService->markUserVerified($id);

        $this->logger->info('Verified user.', ['user' => $user->getAuthIdentifier()]);

        return $user;
    }
}
