<?php

namespace Marketplace\Core\Account\Dtos;

use Marketplace\Core\Account\ValueObjects\Name;
use Marketplace\Core\Account\ValueObjects\Phone;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Foundation\DataTransferObjects\Automake;
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
    #[Automake]
    public ?Salutation $salutation;

    /**
     * @var Name|null
     */
    #[Automake]
    public ?Name $firstName;

    /**
     * @var Name|null
     */
    #[Automake]
    public ?Name $lastName;

    /**
     * @var Phone|null
     */
    #[Automake]
    public ?Phone $phone;
}
