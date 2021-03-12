<?php

namespace Marketplace\Core\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Marketplace\Core\Auth\Reset\SendResetNotification;
use Marketplace\Core\Auth\Verify\SendVerificationNotification;
use Marketplace\Core\User\Dtos\CredentialsDto;

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
        $data = $creds->toArray();
        $data['password'] = $this->hashPassword($data['password']);

        return User::query()->create($data);
    }


    /**
     * Mark the user as verified.
     *
     * @param int|string $userId
     *
     * @return User
     */
    public function markUserVerified(int|string $userId): User
    {
        $user = $this->getUserById($userId);
        $user->setAttribute('email_verified_at', Carbon::now());
        $user->save();

        return $user->fresh();
    }

    /**
     * Get the user by id.
     *
     * @param int|string $userId
     *
     * @return User
     *
     * @throws ModelNotFoundException
     */
    public function getUserById(int|string $userId): User
    {
        return User::query()->findOrFail($userId);
    }

    /**
     * Send the verification email to the user.
     *
     * @param int|string|User $user
     */
    public function sendVerificationEmailToUser(int|string|User $user)
    {
        if (!is_object($user)) {
            $user = $this->getUserById($user);
        }

        $user->notify(new SendVerificationNotification());
    }

    /**
     * Send the password reset email to the user.
     *
     * @param int|string|User $user
     */
    public function sendPasswordResetEmailToUser(int|string|User $user)
    {
        if (!is_object($user)) {
            $user = $this->getUserById($user);
        }

        $user->notify(new SendResetNotification());
    }

    /**
     * Update the password of the user.
     *
     * @param int|string|User $user
     * @param string $password
     *
     * @return User
     */
    public function updatePasswordOfUser(int|string|User $user, string $password): User
    {
        if (!is_object($user)) {
            $user = $this->getUserById($user);
        }

        $user->setAttribute('password', $this->hashPassword($password));
        $user->save();

        return $user->fresh();
    }

    /**
     * Hash a password.
     *
     * @param string $password
     *
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }
}
