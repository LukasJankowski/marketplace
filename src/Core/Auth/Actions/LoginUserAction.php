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
            $this->log('Successful login attempt', $creds);

            return $this->refreshToken->run($user);
        }

        $this->log('Failed login attempt', $creds);
        throw new LoginException();
    }

    /**
     * Log the login attempts.
     *
     * @param $message
     * @param $creds
     */
    private function log($message, $creds)
    {
        $this->logger->info($message, [
            'email' => $creds->getEmail(),
            'type' => $creds->getType()
        ]);
    }
}
