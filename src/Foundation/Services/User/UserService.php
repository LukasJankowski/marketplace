<?php

namespace Marketplace\Foundation\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Marketplace\Core\Data\User\Dtos\CredentialsDto;

class UserService
{
    /**
     * Get the user by his credentials.
     *
     * @param CredentialsDto $creds
     *
     * @return null|Model User
     */
    public function getUserByCredentials(CredentialsDto $creds): ?User
    {
        return User::query()
            ->where('email', $creds->getEmail())
            ->where('type', $creds->getType())
            ->first();
    }

    /**
     * Create a new user.
     *
     * @param CredentialsDto $creds
     *
     * @return null|Model User
     */
    public function create(CredentialsDto $creds): ?User
    {
        return User::query()->create($creds->toArray());
    }
}
