<?php

namespace Marketplace\Core\User\Dtos;

use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Foundation\DataTransferObjects\DataTransferObject;

class PersonDto extends DataTransferObject
{
    public UserDto $user;

    public AccountDto $account;
}
