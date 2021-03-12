<?php

namespace Marketplace\Core\Auth\Verify;

use Marketplace\Core\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\User\UserService;

class VerifyUserAction
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
     * @return User
     */
    public function run(): User
    {
        if (!$this->request->hasValidSignature()) {
            $this->logger->info('Failed user verification.');

            throw new UserVerificationException();
        }

        try {
            $user = $this->userService->markUserVerified($this->request->route('id'));

            $this->logger->info('Verified user.', ['user' => $user->getAuthIdentifier()]);

            return $user;

        } catch (ModelNotFoundException $e) {
            $this->logger->info('Failed to find user to verify.', [
                'route_id' => $this->request->route('id')
            ]);

            throw new UserVerificationException(previous: $e);
        }
    }
}
