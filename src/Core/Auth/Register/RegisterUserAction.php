<?php

namespace Marketplace\Core\Auth\Register;

use Marketplace\Core\User\User;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Foundation\Exceptions\ValidationException;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\Account\AccountService;
use Marketplace\Core\User\UserService;

class RegisterUserAction
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
    ) {}

    /**
     * Register the user.
     *
     * @param UserDto $details
     *
     * @return User
     *
     * @throws ValidationException
     */
    public function run(UserDto $details): User
    {
        $this->checkForDuplicateAccount($details);

        $user = $this->createUser($details);

        UserRegistered::dispatch($user);

        return $user;
    }


    /**
     * Check if the account is duplicated.
     *
     * @param UserDto $details
     *
     * @throws ValidationException
     */
    private function checkForDuplicateAccount(UserDto $details)
    {
        if ($this->userService->getUserByCredentials($details->getCredentials())) {
            $this->logger->info('Duplicate account register attempt', [
                'email' => $details->getCredentials()->getEmail(),
                'type' => $details->getCredentials()->getType()->getClass()
            ]);

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

        $this->logger->info('User registered', [
            'causer' => $user->getAuthIdentifier(),
            'email' => $user->getAttribute('email')
        ]);

        return $user;
    }
}
