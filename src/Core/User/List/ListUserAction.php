<?php

namespace Marketplace\Core\User\List;

use Marketplace\Core\User\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class ListUserAction extends BaseAction
{
    /**
     * RefreshTokenAction constructor.
     *
     * @param UserService $service
     */
    public function __construct(private UserService $service)
    {
    }

    /**
     * Refresh the users API token.
     *
     * @return UserResource
     */
    public function run(): UserResource
    {
        return $this->respond(UserResource::class, $this->service->getAllUsers());
    }
}
