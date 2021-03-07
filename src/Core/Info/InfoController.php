<?php

namespace Marketplace\Core\Info;

use App\Http\Controllers\Controller;

class InfoController extends Controller
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
        return InfoResource::make($action->run());
    }
}
