<?php

namespace Marketplace\Core\Account;

use Marketplace\Core\Account\Dtos\AccountDto;
use Marketplace\Core\User\User;
use Marketplace\Foundation\Exceptions\DatabaseException;

class AccountService
{
    /**
     * Create a new account.
     *
     * @param AccountDto $account
     * @param int|User $user
     *
     * @return Account
     */
    public function create(AccountDto $account, int|User $user): Account
    {
        $data = $account->toArray();
        $data['user_id'] = $user instanceof User
            ? $user->getAuthIdentifier()
            : $user;

        /** @var Account|null $account */
        $account = Account::query()->create($data);
        if (!$account) {
            throw new DatabaseException('marketplace.core.database.failure.insert');
        }

        return $account;
    }
}
