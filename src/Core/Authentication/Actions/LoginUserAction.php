<?php

namespace Marketplace\Core\Authentication\Actions;

use Marketplace\Core\Authentication\Events\UserLoggedIn;
use Marketplace\Core\Authentication\Exceptions\LoginException;
use Marketplace\Core\Authentication\Resources\LoginResource;
use Marketplace\Core\Logging\Logger;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\User;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class LoginUserAction extends BaseAction
{
    /**
     * LoginUserAction constructor.
     *
     * @param RefreshTokenAction $refreshToken
     * @param UserService $service
     * @param Logger $logger
     */
    public function __construct(
        private RefreshTokenAction $refreshToken,
        private UserService $service,
        private Logger $logger
    )
    {
    }

    /**
     * Attempt to login the user.
     *
     * @param UserDto $userDto
     *
     * @return LoginResource
     *
     * @throws LoginException
     */
    public function run(UserDto $userDto): LoginResource
    {
        $user = $this->service->getUserByCredentials($userDto);

        if ($this->checkLogin($userDto, $user)) {
            return $this->refreshToken->run($user);
        }

        $this->logger->info(
            'Failed login attempt',
            [
                'email' => $userDto->email,
                'role' => $userDto->role,
            ]
        );

        throw new LoginException();
    }

    /**
     * Check if the credentials are valid.
     *
     * @param UserDto $userDto
     * @param User|null $user
     *
     * @return bool
     */
    private function checkLogin(UserDto $userDto, null|User $user): bool
    {
        if ($user && $userDto->password->verify($user->getAuthPassword())) {
            $this->logger->info(
                'Successful login attempt',
                [
                    'causer' => $user->getAuthIdentifier(),
                ]
            );

            UserLoggedIn::dispatch($user);

            return true;
        }

        return false;
    }
}
