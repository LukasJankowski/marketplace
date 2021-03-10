<?php

namespace Marketplace\Foundation\Services\Account;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Marketplace\Core\Data\Account\Account;
use Marketplace\Core\Data\Account\Dtos\AccountDto;

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
            ? $user->getAttribute('id')
            : $user;

        return Account::query()->create($data);
    }
}
