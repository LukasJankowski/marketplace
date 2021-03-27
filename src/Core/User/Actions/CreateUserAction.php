<?php

namespace Marketplace\Core\User\Actions;

use Marketplace\Core\Account\AccountService;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Dtos\PersonDto;
use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Exceptions\ValidationException;

class CreateUserAction extends BaseAction
{
    /**
     * CreateUserAction constructor.
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
     * @param PersonDto $details
     *
     * @return UserResource
     *
     * @throws ValidationException
     */
    public function run(PersonDto $details): UserResource
    {
        $this->checkForDuplicateAccount($details);

        $user = $this->createUser($details);

        return $this->respond(UserResource::class, $user);
    }

    /**
     * Check if the account is duplicated.
     *
     * @param PersonDto $details
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function checkForDuplicateAccount(PersonDto $details): void
    {
        if ($this->userService->getUserByCredentials($details->user)) {
            $this->logger->info(
                'Duplicate account register attempt',
                [
                    'email' => $details->user->email,
                    'role' => $details->user->role,
                ]
            );

            throw ValidationException::withMessages(['email' => 'marketplace.core.authentication.register.duplicate']);
        }
    }

    /**
     * Create the user.
     *
     * @param PersonDto $details
     *
     * @return User
     */
    private function createUser(PersonDto $details): User
    {
        $user = $this->userService->create($details->user);
        $account = $this->accountService->create($details->account, $user);
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
