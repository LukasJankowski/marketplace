<?php

namespace Marketplace\Core\User\Dtos;

use Illuminate\Contracts\Support\Arrayable;
use Marketplace\Core\Authorization\ValueObjects\Role;
use Marketplace\Core\User\ValueObjects\Email;
use Marketplace\Core\User\ValueObjects\Password;

class CredentialsDto implements Arrayable
{
    /**
     * CredentialsDto constructor.
     *
     * @param Email $email
     * @param Password $password
     * @param Role $role
     */
    private function __construct(
        private Email $email,
        private Password $password,
        private Role $role
    )
    {
    }

    /**
     * Create the Credentials Dto.
     *
     * @param string $email
     * @param string $password
     * @param string $role
     *
     * @return self
     */
    public static function make(string $email, string $password, string $role): self
    {
        return new self(Email::make($email), Password::make($password), Role::make($role));
    }

    /**
     * Convert data to array.
     *
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'email' => $this->getEmail()->value(),
            'password' => $this->getPassword()->value(),
            'role' => $this->getRole()->value(),
        ];
    }

    /**
     * Getter.
     *
     * @return Email
     */
    public function getEmail(): Email
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
    public function getRole(): Role
    {
        return $this->role;
    }
}
