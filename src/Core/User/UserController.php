<?php

namespace Marketplace\Core\User;

use App\Http\Controllers\Controller;
use Marketplace\Core\User\List\ListUserAction;
use Marketplace\Core\User\List\ListUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ListUserRequest $request
     * @param ListUserAction $action
     *
     * @return UserResource
     */
    public function index(ListUserRequest $request, ListUserAction $action): UserResource
    {
        return $action->run();
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}
