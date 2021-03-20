<?php

namespace Marketplace\Core\Auth\Password;

use Illuminate\Http\JsonResponse;
use Marketplace\Core\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\UserResource;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\User\UserService;

class UpdatePasswordAction extends BaseAction
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
     * @return UserResource
     */
    public function run(CredentialsDto $creds): UserResource
    {
        try {
            return $this->respond(UserResource::class, $this->updatePassword($creds));
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
        $id = $this->request->route('id') ?? throw new ModelNotFoundException();
        $user = $this->userService->updatePasswordOfUser($id, $creds->getPassword());

        $this->logger->info('Updated password of user.', ['user' => $user->getAuthIdentifier()]);

        return $user;
    }
}
