<?php

namespace Marketplace\Core\User\Actions;

use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class ReadUserAction extends BaseAction
{
    /**
     * ListUserAction constructor.
     */
    public function __construct(private UserService $service)
    {
    }

    /**
     * Refresh the users API token.
     */
    public function run(int|string $id): UserResource
    {
        return $this->respond(UserResource::class, $this->service->getUserById($id));
    }
}
