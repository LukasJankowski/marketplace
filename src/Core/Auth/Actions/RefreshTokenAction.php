<?php

namespace Marketplace\Core\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Str;

class RefreshTokenAction
{
    /**
     * Refresh the users API token.
     *
     * @param User $user
     *
     * @return User
     */
    public function run(User $user): User
    {
        $user->setAttribute('api_token', Str::random(32));
        $user->save();

        return $user->fresh();
    }
}
