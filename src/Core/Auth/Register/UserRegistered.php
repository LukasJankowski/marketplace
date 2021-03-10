<?php

namespace Marketplace\Core\Auth\Register;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(private User $user) {}

    /**
     * Getter.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
