<?php

namespace Marketplace\Core\Auth\Login;

use Marketplace\Core\User\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedIn
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
