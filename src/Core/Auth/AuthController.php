<?php

namespace Marketplace\Core\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Marketplace\Core\Auth\Check\CheckLoginAction;
use Marketplace\Core\Auth\Login\LoginUserAction;
use Marketplace\Core\Auth\Refresh\RefreshTokenAction;
use Marketplace\Core\Auth\Register\RegisterUserAction;
use Marketplace\Core\Auth\Login\LoginRequest;
use Marketplace\Core\Auth\Register\RegisterRequest;
use Marketplace\Core\Auth\Login\LoginResource;
use Marketplace\Core\Data\User\UserResource;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @param LoginUserAction $action
     *
     * @return LoginResource
     *
     * @throws Login\LoginException
     */
    public function login(LoginRequest $request, LoginUserAction $action): LoginResource
    {
        return LoginResource::make($action->run($request->getDto()));
    }

    /**
     * Check the auth status.
     *
     * @param CheckLoginAction $action
     *
     * @return LoginResource
     *
     * @throws Login\LoginException
     */
    public function check(CheckLoginAction $action): LoginResource
    {
        return LoginResource::make($action->run());
    }


    /**
     * Refresh the users token.
     *
     * @param RefreshTokenAction $action
     *
     * @return LoginResource
     */
    public function refresh(RefreshTokenAction $action): LoginResource
    {
        return LoginResource::make($action->run());
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @param RegisterUserAction $action
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, RegisterUserAction $action): JsonResponse
    {
        return UserResource::make($action->run($request->getDto()))
            ->response()
            ->setStatusCode(201);
    }
}
