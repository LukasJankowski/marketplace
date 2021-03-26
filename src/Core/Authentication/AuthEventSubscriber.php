<?php

namespace Marketplace\Core\Authentication;

use Marketplace\Core\Authentication\Register\UserRegistered;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Subscribers\ListensTo;

class AuthEventSubscriber
{
    /**
     * React on a user that registered.
     *
     * @param UserRegistered $event
     *
     * @return void
     */
    #[ListensTo(UserRegistered::class)]
    public function handleUserRegistered(UserRegistered $event): void
    {
        (new UserService())->sendVerificationEmailToUser($event->getUser());
    }
}
