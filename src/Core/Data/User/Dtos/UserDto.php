<?php

namespace Marketplace\Core\Data\User\Dtos;

class UserDto
{
    /**
     * UserDto constructor.
     *
     * @param CredentialsDto $credentials
     * @param PersonDto $person
     */
    private function __construct(
        private CredentialsDto $credentials,
        private PersonDto $person,
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
     * @param string $phone
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
        string $phone,
    ): self
    {
        return new self(
            CredentialsDto::make($email, $password, $type),
            PersonDto::make($salutation, $firstName, $lastName, $phone)
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
     * @return PersonDto
     */
    public function getPerson(): PersonDto
    {
        return $this->person;
    }
}
