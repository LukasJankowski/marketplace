<?php

namespace Marketplace\Core\Auth;

use App\Http\Controllers\Controller;
use Marketplace\Core\Auth\Actions\CheckLoginAction;
use Marketplace\Core\Auth\Actions\LoginUserAction;
use Marketplace\Core\Auth\Requests\LoginRequest;
use Marketplace\Core\Auth\Resources\LoginResource;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware(['throttle:5,1', 'guest'])->only(['login']);
    }

    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @param LoginUserAction $action
     *
     * @return LoginResource
     *
     * @throws Exceptions\LoginException
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
     * @throws Exceptions\LoginException
     */
    public function check(CheckLoginAction $action): LoginResource
    {
        return LoginResource::make($action->run());
    }
}
