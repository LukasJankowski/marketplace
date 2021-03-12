<?php

namespace Marketplace\Core\User\Dtos;

use Marketplace\Core\Account\Dtos\AccountDto;

class UserDto
{
    /**
     * UserDto constructor.
     *
     * @param CredentialsDto $credentials
     * @param AccountDto $person
     */
    private function __construct(
        private CredentialsDto $credentials,
        private AccountDto $person,
    ) {}

    /**
     * Create the User Dto.
     *
     * @param string $email
     * @param string $password
     * @param string $type
     * @param null|string $salutation
     * @param string $firstName
     * @param string $lastName
     * @param null|string $phone
     *
     * @return self
     */
    public static function make(
        string $email,
        string $password,
        string $type,
        ?string $salutation,
        string $firstName,
        string $lastName,
        ?string $phone,
    ): self
    {
        return new self(
            CredentialsDto::make($email, $password, $type),
            AccountDto::make($salutation, $firstName, $lastName, $phone)
        );
    }

    /**
     * Getter.
     *
     * @return CredentialsDto
     */
    public function getCredentials(): CredentialsDto
    {
        return $this->credentials;
    }

    /**
     * Getter.
     *
     * @return AccountDto
     */
    public function getAccount(): AccountDto
    {
        return $this->person;
    }
}
