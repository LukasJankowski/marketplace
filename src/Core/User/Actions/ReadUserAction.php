<?php

namespace Marketplace\Core\User\Actions;

use Marketplace\Core\User\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class ReadUserAction extends BaseAction
{
    /**
     * ListUserAction constructor.
     *
     * @param UserService $service
     */
    public function __construct(private UserService $service)
    {
    }

    /**
     * Refresh the users API token.
     *
     * @param int|string $id
     *
     * @return UserResource
     */
    public function run(int|string $id): UserResource
    {
        return $this->respond(UserResource::class, $this->service->getUserById($id));
    }
}
