<?php


namespace Marketplace\Core\Http\Controllers;


use Marketplace\Core\Actions\GetInfoAction;
use Marketplace\Core\Http\Resources\InfoResource;

class InfoController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param GetInfoAction $action
     *
     * @return InfoResource
     */
    public function __invoke(GetInfoAction $action): InfoResource
    {
        return new InfoResource($action->run());
    }
}
