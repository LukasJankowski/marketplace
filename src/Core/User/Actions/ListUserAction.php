<?php

namespace Marketplace\Core\User\Actions;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Core\User\UserService;
use Marketplace\Foundation\Actions\BaseAction;

class ListUserAction extends BaseAction
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
     * @return AnonymousResourceCollection
     */
    public function run(): AnonymousResourceCollection
    {
        return $this->respond(UserResource::class, $this->service->getAllUsers(), true);
    }
}
