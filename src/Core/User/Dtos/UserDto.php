<?php

namespace Marketplace\Core\User\Dtos;

use Marketplace\Core\Authorization\ValueObjects\Role;
use Marketplace\Core\User\ValueObjects\Email;
use Marketplace\Core\User\ValueObjects\Password;
use Marketplace\Foundation\DataTransferObjects\Automake;
use Marketplace\Foundation\DataTransferObjects\DataTransferObject;

class UserDto extends DataTransferObject
{
    public ?int $userId;

    #[Automake]
    public ?Email $email;

    #[Automake]
    public ?Password $password;

    #[Automake]
    public ?Role $role;

    public ?string $apiToken;
}
