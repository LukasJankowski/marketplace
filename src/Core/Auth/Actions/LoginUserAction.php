<?php

namespace Marketplace\Core\Auth\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Marketplace\Core\Auth\Exceptions\LoginException;
use Marketplace\Core\Auth\UserCredentialsDto;
use Marketplace\Foundation\Logging\Logger;

class LoginUserAction
{
    /**
     * LoginUserAction constructor.
     *
     * @param RefreshTokenAction $refreshToken
     * @param Logger $logger
     */
    public function __construct(
        private RefreshTokenAction $refreshToken,
        private Logger $logger
    ) {}

    /**
     * Attempt to login the user.
     *
     * @param UserCredentialsDto $creds
     *
     * @return User
     *
     * @throws LoginException
     * @throws ModelNotFoundException
     */
    public function run(UserCredentialsDto $creds): User
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', $creds->getEmail())
            ->where('type', $creds->getType())
            ->first();

        if ($user && Hash::check($creds->getPassword(), $user->getAuthPassword())) {
            $this->logger->info('Successful login attempt', [
                'causer' => $user->getAuthIdentifier()
            ]);

            return $this->refreshToken->run($user);
        }

        $this->logger->info('Failed login attempt', [
            'email' => $creds->getEmail(),
            'type' => $creds->getType()
        ]);

        throw new LoginException();
    }
}
