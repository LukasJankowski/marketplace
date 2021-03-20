<?php

namespace Marketplace\Core\Auth\Register;

use Marketplace\Core\Account\AccountService;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Exceptions\ValidationException;
use Marketplace\Foundation\Logging\Logger;

class RegisterUserAction extends BaseAction
{
    /**
     * RegisterUserAction constructor.
     *
     * @param Logger $logger
     * @param UserService $userService
     * @param AccountService $accountService
     */
    public function __construct(
        private Logger $logger,
        private UserService $userService,
        private AccountService $accountService
    )
    {
    }

    /**
     * Register the user.
     *
     * @param UserDto $details
     *
     * @return UserResource
     *
     * @throws ValidationException
     */
    public function run(UserDto $details): UserResource
    {
        $this->checkForDuplicateAccount($details);

        $user = $this->createUser($details);

        UserRegistered::dispatch($user);

        return $this->respond(UserResource::class, $user);
    }

    /**
     * Check if the account is duplicated.
     *
     * @param UserDto $details
     *
     * @return void
     * @throws ValidationException
     *
     */
    private function checkForDuplicateAccount(UserDto $details): void
    {
        if ($this->userService->getUserByCredentials($details->getCredentials())) {
            $this->logger->info(
                'Duplicate account register attempt',
                [
                    'email' => $details->getCredentials()->getEmail(),
                    'role' => $details->getCredentials()->getRole()->getRole(),
                ]
            );

            throw ValidationException::withMessages(['email' => 'marketplace.core.auth.register.duplicate']);
        }
    }

    /**
     * Create the user.
     *
     * @param UserDto $details
     *
     * @return User
     */
    private function createUser(UserDto $details): User
    {
        $user = $this->userService->create($details->getCredentials());
        $account = $this->accountService->create($details->getAccount(), $user);
        $user->setRelation('account', $account);

        $this->logger->info(
            'User registered',
            [
                'causer' => $user->getAuthIdentifier(),
                'email' => $user->getAttribute('email'),
            ]
        );

        return $user;
    }
}
