<?php

namespace Marketplace\Foundation\Services\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Marketplace\Core\Auth\Verify\SendVerificationNotification;
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

        return $user;
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
}
