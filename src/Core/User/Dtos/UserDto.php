<?php

namespace Marketplace\Core\User\Dtos;

use Marketplace\Core\Authorization\ValueObjects\Role;
use Marketplace\Core\User\ValueObjects\Email;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\DataTransferObjects\DataTransferObject;

class UserDto extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $userId;

    /**
     * @var Email|null
     */
    public ?Email $email;

    /**
     * @var Password|null
     */
    public ?Password $password;

    /**
     * @var Role|null
     */
    public ?Role $role;

    /**
     * @var string|null
     */
    public ?string $apiToken;

    /**
     * Create the Credentials Dto.
     *
     * @param int|null $userId
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string|null $apiToken
     *
     * @return self
     */
    public static function make(?int $userId, string $email, string $password, string $role, ?string $apiToken): self
    {
        return new static(
            [
                'userId' => $userId,
                'email' => Email::make($email),
                'password' => Password::make($password),
                'role' => Role::make($role),
                'apiToken' => $apiToken
            ]
        );
    }
}
