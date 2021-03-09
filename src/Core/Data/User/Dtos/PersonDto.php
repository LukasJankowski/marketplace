<?php

namespace Marketplace\Core\Data\User\Dtos;

use Marketplace\Core\Data\User\ValueObjects\Salutation;

class PersonDto
{
    /**
     * PersonDto constructor.
     *
     * @param Salutation $salutation
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     */
    private function __construct(
        private Salutation $salutation,
        private string $firstName,
        private string $lastName,
        private string $phone
    ) {}

    /**
     * Create the Person Dto.
     *
     * @param string $salutation
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     *
     * @return self
     */
    public static function make(
        string $salutation,
        string $firstName,
        string $lastName,
        string $phone
    ): self
    {
        return new self(
            Salutation::make($salutation),
            $firstName,
            $lastName,
            $phone
        );
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getSalutation(): string
    {
        return $this->salutation->getSalutation();
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
}
