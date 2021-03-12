<?php

namespace Marketplace\Core\User\Dtos;

use Illuminate\Contracts\Support\Arrayable;
use Marketplace\Core\Type\ValueObjects\Type;
use Marketplace\Core\User\ValueObjects\Password;

class CredentialsDto implements Arrayable
{
    /**
     * CredentialsDto constructor.
     *
     * @param string $email
     * @param Password $password
     * @param Type $type
     */
    private function __construct(
        private string $email,
        private Password $password,
        private Type $type
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
        return new self($email, Password::make($password), Type::make($type));
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
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * Convert data to array.
     *
     * @return array
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
