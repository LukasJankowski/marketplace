<?php

namespace Marketplace\Core\Auth\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Marketplace\Core\Auth\Exceptions\LoginException;
use Marketplace\Core\Auth\UserCredentialsDto;

class LoginUserAction
{
    /**
     * LoginUserAction constructor.
     *
     * @param RefreshTokenAction $refreshToken
     */
    public function __construct(private RefreshTokenAction $refreshToken) {}

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
            return $this->refreshToken->run($user);
        }

        throw new LoginException();
    }
}
