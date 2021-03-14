<?php

namespace Marketplace\Core\User\Dtos;

use Illuminate\Contracts\Support\Arrayable;
use Marketplace\Core\Role\ValueObjects\Role;
use Marketplace\Core\User\ValueObjects\Password;

class CredentialsDto implements Arrayable
{
    /**
     * CredentialsDto constructor.
     *
     * @param string $email
     * @param Password $password
     * @param Role $type
     */
    private function __construct(
        private string $email,
        private Password $password,
        private Role $type
    ) {}

    /**
     * Create the Credentials Dto.
     *
     * @param string $email
     * @param string $password
     * @param string $type
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public static function make(string $email, string $password, string $type): self
    {
        return new self($email, Password::make($password), Role::make($type));
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Getter.
     *
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * Getter.
     *
     * @return Role
     */
    public function getType(): Role
    {
        return $this->type;
    }

    /**
     * Convert data to array.
     *
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword()->getPassword(),
            'type' => $this->getType()->getClass(),
        ];
    }
}
