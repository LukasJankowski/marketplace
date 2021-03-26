<?php

namespace Marketplace\Core\Authentication\Register;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Marketplace\Core\User\User;

class UserRegistered
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(private User $user)
    {
    }

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
