<?php

namespace Marketplace\Core\Account\Dtos;

use Marketplace\Core\Account\ValueObjects\Name;
use Marketplace\Core\Account\ValueObjects\Phone;
use Marketplace\Core\Account\ValueObjects\Salutation;
use Marketplace\Foundation\DataTransferObjects\Automake;
use Marketplace\Foundation\DataTransferObjects\DataTransferObject;

class AccountDto extends DataTransferObject
{
    public ?int $userId;

    #[Automake]
    public ?Salutation $salutation;

    #[Automake]
    public ?Name $firstName;

    #[Automake]
    public ?Name $lastName;

    #[Automake]
    public ?Phone $phone;
}
