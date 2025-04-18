<?php

namespace Marketplace\Core\Authentication\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Marketplace\Core\User\User;

class UserLoggedIn
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private User $user)
    {
    }

    /**
     * Getter.
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
