<?php

namespace Marketplace\Core\Auth\Register;

use App\Models\User;
use Marketplace\Core\Data\User\Dtos\UserDto;
use Marketplace\Foundation\Exceptions\BusinessException;
use Marketplace\Foundation\Exceptions\ValidationException;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Foundation\Services\Account\AccountService;
use Marketplace\Foundation\Services\User\UserService;

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
     * @throws BusinessException
     */
    public function run(UserDto $details): User
    {
        if ($this->userService->getUserByCredentials($details->getCredentials())) {
            $this->logger->info('Duplicate account register attempt', [
                'email' => $details->getCredentials()->getEmail(),
                'type' => $details->getCredentials()->getType()
            ]);

            throw new BusinessException('marketplace.core.auth.register.duplicate');
        }

        $user = $this->userService->create($details->getCredentials());
        $account = $this->accountService->create($details->getAccount(), $user);
        $user->setRelation('account', $account);

        $this->logger->info('User registered', [
            'causer' => $user->getAuthIdentifier(),
            'email' => $user->getAttribute('email')
        ]);

        // Send events
        return $user;
    }
}
