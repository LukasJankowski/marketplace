<?php

namespace Marketplace\Core\Auth;

use Marketplace\Core\Auth\Register\UserRegistered;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Subscribers\SubscriberHelperTrait;

class AuthEventSubscriber
{
    use SubscriberHelperTrait;

    /**
     * @const array
     */
    public const SUBSCRIBER = [
        UserRegistered::class => [
            [self::class, 'handleUserRegistered'],
        ],
    ];

    /**
     * React on a user that registered.
     *
     * @param UserRegistered $event
     */
    public function handleUserRegistered(UserRegistered $event)
    {
        (new UserService())->sendVerificationEmailToUser($event->getUser());
    }
}
