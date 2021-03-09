<?php

namespace Marketplace\Core\Auth\Refresh;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RefreshTokenAction
{
    /**
     * RefreshTokenAction constructor.
     *
     * @param Request $request
     */
    public function __construct(private Request $request) {}

    /**
     * Refresh the users API token.
     *
     * @param null|User $user
     *
     * @return User
     */
    public function run(?User $user = null): User
    {
        // This action may only be run in an authenticated context or
        // when it can be ensured that a valid User model is passed.
        if ($user === null) {
            $user = $this->request->user() ?? throw new \LogicException(
                sprintf(
                    'TokenRefresh on unauthenticated user. From: %s',
                    $this->request->ip()
                )
            );
        }

        $user->setAttribute('api_token', Str::random(32));
        $user->save();

        return $user->fresh();
    }
}
