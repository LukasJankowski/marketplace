<?php

namespace Marketplace\Core\Authentication\Subscribers;

use Marketplace\Core\Authentication\Events\UserRegistered;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Subscribers\ListensTo;

class AuthEventSubscriber
{
    /**
     * React on a user that registered.
     */
    #[ListensTo(UserRegistered::class)]
    public function handleUserRegistered(UserRegistered $event): void
    {
        (new UserService())->sendVerificationEmailToUser($event->getUser());
    }
}
