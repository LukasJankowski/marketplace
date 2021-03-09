<?php

namespace Marketplace\Core\Auth\Actions;

use App\Models\User;
use Marketplace\Core\Data\User\Dtos\UserDto;
use Marketplace\Foundation\Logging\Logger;

class RegisterUserAction
{
    /**
     * RegisterUserAction constructor.
     *
     * @param Logger $logger
     */
    public function __construct(private Logger $logger) {}

    /**
     * Register the user.
     *
     * @param UserDto $details
     *
     * @return User
     */
    public function run(UserDto $details): User
    {
        // WIP
        return User::factory()->make();
    }
}
