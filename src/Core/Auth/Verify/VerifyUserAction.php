<?php

namespace Marketplace\Core\Auth\Verify;

use Marketplace\Core\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Marketplace\Core\User\UserResource;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\User\UserService;

class VerifyUserAction extends BaseAction
{
    /**
     * VerifyUserAction constructor.
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
     * Verify the users email.
     *
     * @return UserResource
     */
    public function run(): UserResource
    {
        $this->checkSignature();

        try {
            return $this->respond(UserResource::class, $this->verifyUser());
        } catch (ModelNotFoundException $e) {
            $this->logger->info('Failed to find user to verify.', [
                'route_id' => $this->request->route('id')
            ]);

            throw new UserVerificationException(previous: $e);
        }
    }

    /**
     * Check the urls signature.
     *
     * @throws UserVerificationException
     *
     * @return void
     */
    private function checkSignature(): void
    {
        if (!$this->request->hasValidSignature()) {
            $this->logger->info('Failed user verification.');

            throw new UserVerificationException();
        }
    }

    /**
     * Verify the users email.
     *
     * @return User
     */
    private function verifyUser(): User
    {
        $id = $this->request->route('id') ?? throw new ModelNotFoundException();
        $user = $this->userService->markUserVerified($id);

        $this->logger->info('Verified user.', ['user' => $user->getAuthIdentifier()]);

        return $user;
    }
}
