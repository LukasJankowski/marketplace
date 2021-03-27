<?php

namespace Marketplace\Core\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Marketplace\Core\User\Actions\CreateUserAction;
use Marketplace\Core\User\Actions\ListUserAction;
use Marketplace\Core\User\Actions\ReadUserAction;
use Marketplace\Core\User\Requests\CreateUserRequest;
use Marketplace\Core\User\Requests\ListUserRequest;
use Marketplace\Core\User\Requests\ReadUserRequest;
use Marketplace\Core\User\Resources\UserResource;
use Marketplace\Foundation\Exceptions\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(ListUserRequest $request, ListUserAction $action): AnonymousResourceCollection
    {
        return $action->run();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws ValidationException
     */
    public function create(CreateUserRequest $request, CreateUserAction $action): JsonResponse
    {
        return $action->run($request->asDto())
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function read(ReadUserRequest $request, ReadUserAction $action): UserResource
    {
        return $action->run($request->route('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete()
    {
        //
    }
}
