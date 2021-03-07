<?php

namespace Marketplace\Core\Auth;

class UserCredentialsDto
{
    /**
     * UserCredentialsDto constructor.
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
     * Create the UserCredentials Dto.
     *
     * @param string $email
     * @param string $password
     * @param string $type
     *
     * @return UserCredentialsDto
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
