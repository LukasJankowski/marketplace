<?php

namespace Marketplace\Core\User\Dtos;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Marketplace\Core\Account\Dtos\AccountDto;

class UserDto implements Arrayable
{
    /**
     * UserDto constructor.
     *
     * @param CredentialsDto $credentials
     * @param AccountDto $person
     */
    private function __construct(
        private CredentialsDto $credentials,
        private AccountDto $person
    )
    {
    }

    /**
     * Create the User Dto.
     *
     * @param string $email
     * @param string $password
     * @param string $role
     * @param null|string $salutation
     * @param string $firstName
     * @param string $lastName
     * @param null|string $phone
     *
     * @return self
     * @throws Exception
     */
    public static function make(
        string $email,
        string $password,
        string $role,
        ?string $salutation,
        string $firstName,
        string $lastName,
        ?string $phone
    ): self
    {
        return new self(
            CredentialsDto::make($email, $password, $role),
            AccountDto::make($salutation, $firstName, $lastName, $phone)
        );
    }

    /**
     * Convert data to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'credentials' => $this->getCredentials(),
            'account' => $this->getAccount()
        ];
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
