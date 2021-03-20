<?php

namespace Marketplace\Core\Auth;

use Marketplace\Core\Auth\Login\LoginResource;
use Marketplace\Core\User\User;
use Illuminate\Http\Request;
use Marketplace\Core\Auth\Login\LoginException;
use Marketplace\Foundation\Actions\BaseAction;
use Marketplace\Foundation\Logging\Logger;

class CheckLoginAction extends BaseAction
{
    /**
     * CheckLoginAction constructor.
     *
     * @param Logger $logger
     * @param Request $request
     */
    public function __construct(
        private Logger $logger,
        private Request $request
    ) {}

    /**
     * Check for login status.
     *
     * @return LoginResource
     *
     * @throws LoginException
     */
    public function run(): LoginResource
    {
        /** @var User|null $user */
        $user = $this->request->user();

        if ($user) {
            $this->logger->info('Successful auth check', ['causer' => $user->getAuthIdentifier()]);

            return $this->respond(LoginResource::class, $user);
        }

        $this->logger->info('Failed auth check');

        throw new LoginException();
    }
}
