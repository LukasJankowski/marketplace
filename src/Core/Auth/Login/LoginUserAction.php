<?php

namespace Marketplace\Core\Auth\Login;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Marketplace\Core\Auth\Refresh\RefreshTokenAction;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Foundation\Logging\Logger;
use Marketplace\Core\Type\TypeService;
use Marketplace\Core\User\UserService;

class LoginUserAction
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
    ) {}

    /**
     * Attempt to login the user.
     *
     * @param CredentialsDto $creds
     *
     * @return User
     *
     * @throws LoginException
     * @throws ModelNotFoundException
     */
    public function run(CredentialsDto $creds): User
    {
        $user = $this->service->getUserByCredentials($creds);

        if ($user && Hash::check($creds->getPassword(), $user->getAuthPassword())) {
            $this->logger->info('Successful login attempt', [
                'causer' => $user->getAuthIdentifier()
            ]);

            UserLoggedIn::dispatch($user);

            return $this->refreshToken->run($user);
        }

        $this->logger->info('Failed login attempt', [
            'email' => $creds->getEmail(),
            'type' => TypeService::getKeyByClass($creds->getType())
        ]);

        throw new LoginException();
    }
}
