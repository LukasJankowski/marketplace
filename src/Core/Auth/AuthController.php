<?php

namespace Marketplace\Core\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Marketplace\Core\Auth\Check\CheckLoginAction;
use Marketplace\Core\Auth\Login\LoginUserAction;
use Marketplace\Core\Auth\Password\UpdatePasswordAction;
use Marketplace\Core\Auth\Password\UpdatePasswordRequest;
use Marketplace\Core\Auth\Refresh\RefreshTokenAction;
use Marketplace\Core\Auth\Register\RegisterUserAction;
use Marketplace\Core\Auth\Login\LoginRequest;
use Marketplace\Core\Auth\Register\RegisterRequest;
use Marketplace\Core\Auth\Login\LoginResource;
use Marketplace\Core\Auth\Reset\ResetPasswordAction;
use Marketplace\Core\Auth\Reset\ResetRequest;
use Marketplace\Core\Auth\Reset\ResetResource;
use Marketplace\Core\Auth\Verify\VerifyUserAction;
use Marketplace\Core\Data\User\UserResource;
use Marketplace\Foundation\Exceptions\BusinessException;
use Marketplace\Foundation\Exceptions\ValidationException;

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
     *
     * @throws BusinessException
     */
    public function register(RegisterRequest $request, RegisterUserAction $action): JsonResponse
    {
        return UserResource::make($action->run($request->getDto()))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Verify a user by email.
     *
     * @param VerifyUserAction $action
     *
     * @return UserResource
     */
    public function verify(VerifyUserAction $action): UserResource
    {
        return UserResource::make($action->run());
    }

    /**
     * Reset a users password.
     *
     * @param ResetRequest $request
     * @param ResetPasswordAction $action
     *
     * @return ResetResource
     *
     * @throws ValidationException
     */
    public function reset(ResetRequest $request, ResetPasswordAction $action): ResetResource
    {
        return ResetResource::make($action->run($request->getDto()));
    }

    /**
     * Update a users password.
     *
     * @param UpdatePasswordRequest $request
     * @param UpdatePasswordAction $action
     *
     * @return UserResource
     */
    public function password(UpdatePasswordRequest $request, UpdatePasswordAction $action): UserResource
    {
        return UserResource::make($action->run($request->getDto()));
    }
}
