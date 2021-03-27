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
}
