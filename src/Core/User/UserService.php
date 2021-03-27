<?php

namespace Marketplace\Core\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\Authentication\Notifications\SendResetNotification;
use Marketplace\Core\Authentication\Notifications\SendVerificationNotification;
use Marketplace\Core\User\Dtos\UserDto;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\Exceptions\DatabaseException;

class UserService
{
    /**
     * Get all users.
     */
    public function getAllUsers(): Collection
    {
        return User::query()->get();
    }

    /**
     * Get the user by his credentials.
     */
    public function getUserByCredentials(UserDto $user): ?User
    {
        return User::query()
            ->where('email', $user->email)
            ->where('role', $user->role)
            ->first();
    }

    /**
     * Create a new user.
     */
    public function create(UserDto $user): User
    {
        /** @var User|null $user */
        $user = User::create($user->toArray());
        if (! $user) {
            throw new DatabaseException('marketplace.core.database.failure.insert');
        }

        return $user;
    }

    /**
     * Mark the user as verified.
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
     * @throws ModelNotFoundException
     */
    public function getUserById(int|string $userId): User
    {
        return User::query()->findOrFail($userId);
    }

    /**
     * Send the verification email to the user.
     */
    public function sendVerificationEmailToUser(int|string|User $user): void
    {
        $user = $this->getUser($user);
        $user->notify(new SendVerificationNotification());
    }

    /**
     * Get correct user.
     */
    private function getUser(int|string|User $user): User
    {
        return ! is_object($user) ? $this->getUserById($user) : $user;
    }

    /**
     * Send the password reset email to the user.
     */
    public function sendPasswordResetEmailToUser(int|string|User $user): void
    {
        $user = $this->getUser($user);
        $user->notify(new SendResetNotification());
    }

    /**
     * Update the password of the user.
     */
    public function updatePasswordOfUser(int|string|User $user, Password $password): void
    {
        $user = $this->getUser($user);
        $user->setAttribute('password', $password);
        $user->save();
    }
}
