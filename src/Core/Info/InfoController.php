<?php

namespace Marketplace\Core\Info;

use Marketplace\Foundation\Http\BaseController;

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
