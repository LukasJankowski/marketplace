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
    public function dump(GetInfoAction $action): InfoResource
    {
        return $action->run();
    }
}
