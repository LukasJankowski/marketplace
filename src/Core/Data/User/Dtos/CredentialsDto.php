<?php

namespace Marketplace\Core\Data\User\Dtos;

class CredentialsDto
{
    /**
     * CredentialsDto constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $type
     */
    private function __construct(
        private string $email,
        private string $password,
        private string $type
    ) {}

    /**
     * Create the Credentials Dto.
     *
     * @param string $email
     * @param string $password
     * @param string $type
     *
     * @return self
     */
    public static function make(string $email, string $password, string $type): self
    {
        return new self($email, $password, $type);
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
