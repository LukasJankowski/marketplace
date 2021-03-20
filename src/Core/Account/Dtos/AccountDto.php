<?php

namespace Marketplace\Core\Account\Dtos;

use Illuminate\Contracts\Support\Arrayable;
use Marketplace\Core\Account\ValueObjects\Salutation;

class AccountDto implements Arrayable
{
    /**
     * PersonDto constructor.
     *
     * @param Salutation $salutation
     * @param string $firstName
     * @param string $lastName
     * @param null|string $phone
     */
    private function __construct(
        private Salutation $salutation,
        private string $firstName,
        private string $lastName,
        private ?string $phone
    )
    {
    }

    /**
     * Create the Person Dto.
     *
     * @param null|string $salutation
     * @param string $firstName
     * @param string $lastName
     * @param null|string $phone
     *
     * @return self
     */
    public static function make(
        ?string $salutation,
        string $firstName,
        string $lastName,
        ?string $phone
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
     * Convert data to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'salutation' => optional($this->getSalutation())->getSalutation(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'phone' => $this->getPhone(),
        ];
    }

    /**
     * Getter.
     *
     * @return Salutation|null
     */
    public function getSalutation(): ?Salutation
    {
        return $this->salutation;
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
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
}
