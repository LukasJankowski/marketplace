<?php

namespace Marketplace\Core\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\Authentication\Reset\SendResetNotification;
use Marketplace\Core\Authentication\Verify\SendVerificationNotification;
use Marketplace\Core\User\Dtos\CredentialsDto;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\Exceptions\DatabaseException;

class UserService
{
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::query()->get();
    }

    /**
     * Get the user by his credentials.
     *
     * @param CredentialsDto $creds
     *
     * @return null|User
     */
    public function getUserByCredentials(CredentialsDto $creds): ?User
    {
        return User::query()
            ->where('email', $creds->getEmail())
            ->where('role', $creds->getRole()->getRole())
            ->first();
    }

    /**
     * Create a new user.
     *
     * @param CredentialsDto $creds
     *
     * @return User
     */
    public function create(CredentialsDto $creds): User
    {
        /** @var User|null $user */
        $user = User::query()->create($creds->toArray());
        if (!$user) {
            throw new DatabaseException('marketplace.core.database.failure.insert');
        }

        return $user;
    }

    /**
     * Mark the user as verified.
     *
     * @param int|string $userId
     *
     * @return void
     */
    public function markUserVerified(int|string $userId): void
    {
        $user = $this->getUserById($userId);
        $user->setAttribute('email_verified_at', Carbon::now());
        $user->save();
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
     *
     * @return void
     */
    public function sendVerificationEmailToUser(int|string|User $user): void
    {
        $user = $this->getUser($user);
        $user->notify(new SendVerificationNotification());
    }

    /**
     * Get correct user.
     *
     * @param int|string|User $user
     *
     * @return User
     */
    private function getUser(int|string|User $user): User
    {
        return !is_object($user) ? $this->getUserById($user) : $user;
    }

    /**
     * Send the password reset email to the user.
     *
     * @param int|string|User $user
     *
     * @return void
     */
    public function sendPasswordResetEmailToUser(int|string|User $user): void
    {
        $user = $this->getUser($user);
        $user->notify(new SendResetNotification());
    }

    /**
     * Update the password of the user.
     *
     * @param int|string|User $user
     * @param Password $password
     *
     * @return void
     */
    public function updatePasswordOfUser(int|string|User $user, Password $password): void
    {
        $user = $this->getUser($user);
        $user->setAttribute('password', $password->getPassword());
        $user->save();
    }
}
