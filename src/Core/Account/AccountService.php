<?php

namespace Marketplace\Core\Account;

use Marketplace\Core\User\User;
use Illuminate\Database\Eloquent\Model;
use Marketplace\Core\Account\Dtos\AccountDto;

class AccountService
{
    /**
     * Create a new account.
     *
     * @param AccountDto $account
     * @param int|User $user
     *
     * @return null|Model Account
     */
    public function create(AccountDto $account, int|User $user): ?Account
    {
        $data = $account->toArray();
        $data['user_id'] = $user instanceof User
            ? $user->getAuthIdentifier()
            : $user;

        return Account::query()->create($data);
    }
}
