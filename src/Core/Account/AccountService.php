<?php

namespace Marketplace\Core\Account;

use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Core\User\User;
use Marketplace\Foundation\Exceptions\DatabaseException;

class AccountService
{
    /**
     * Create a new account.
     */
    public function create(AccountDto $account, int|User $user): Account
    {
        $account->userId = $user instanceof User
            ? $user->getAuthIdentifier()
            : $user;

        /** @var Account|null $account */
        $account = Account::create($account->toArray());
        if (!$account) {
            throw new DatabaseException('marketplace.core.database.failure.insert');
        }

        return $account;
    }
}
