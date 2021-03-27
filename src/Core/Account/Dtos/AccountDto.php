<?php

namespace Marketplace\Core\Account\Dtos;

use Marketplace\Core\Account\ValueObjects\Name;
use Marketplace\Core\Account\ValueObjects\Phone;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Foundation\DataTransferObjects\DataTransferObject;

class AccountDto extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $userId;

    /**
     * @var Salutation|null
     */
    public ?Salutation $salutation;

    /**
     * @var Name|null
     */
    public ?Name $firstName;

    /**
     * @var Name|null
     */
    public ?Name $lastName;

    /**
     * @var Phone|null
     */
    public ?Phone $phone;

    /**
     * Create a new instance of self.
     *
     * @param null|int $userId
     * @param null|string $salutation
     * @param string $firstName
     * @param string $lastName
     * @param null|string $phone
     *
     * @return self
     */
    public static function make(
        ?int $userId,
        ?string $salutation,
        string $firstName,
        string $lastName,
        ?string $phone
    ): self
    {
        return new static(
            [
                'id' => $userId,
                'salutation' => Salutation::make($salutation),
                'firstName' => Name::make($firstName),
                'lastName' => Name::make($lastName),
                'phone' => Phone::make($phone),
            ]
        );
    }
}
