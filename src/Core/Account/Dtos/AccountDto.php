<?php

namespace Marketplace\Core\Account\Dtos;

use Illuminate\Contracts\Support\Arrayable;
use Marketplace\Core\Account\ValueObjects\Name;
use Marketplace\Core\Account\ValueObjects\Phone;
use Marketplace\Core\Account\ValueObjects\Salutation;

class AccountDto implements Arrayable
{
    /**
     * AccountDto constructor.
     *
     * @param Salutation $salutation
     * @param Name $firstName
     * @param Name $lastName
     * @param Phone $phone
     */
    private function __construct(
        private Salutation $salutation,
        private Name $firstName,
        private Name $lastName,
        private Phone $phone
    )
    {
    }

    /**
     * Create a new instance of self.
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
            Name::make($firstName),
            Name::make($lastName),
            Phone::make($phone)
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
            'salutation' => $this->getSalutation()->value(),
            'first_name' => $this->getFirstName()->value(),
            'last_name' => $this->getLastName()->value(),
            'phone' => $this->getPhone()->value(),
        ];
    }

    /**
     * Getter.
     *
     * @return Salutation
     */
    public function getSalutation(): Salutation
    {
        return $this->salutation;
    }

    /**
     * Getter.
     *
     * @return Name
     */
    public function getFirstName(): Name
    {
        return $this->firstName;
    }

    /**
     * Getter.
     *
     * @return Name
     */
    public function getLastName(): Name
    {
        return $this->lastName;
    }

    /**
     * Getter.
     *
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
