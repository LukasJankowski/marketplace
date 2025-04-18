<?php

namespace Marketplace\Foundation\Tests;

use Marketplace\Core\User\User;

trait TestsHelperTrait
{
    /**
     * Create a user.
     *
     * @param array<string, string> $args
     */
    private function getUser(array $args = ['role' => 'customer']): User
    {
        return User::factory()->create($args);
    }
}
