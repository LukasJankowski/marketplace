<?php

namespace Marketplace\Core\Info;

use App\Http\Controllers\Controller;
use Marketplace\Core\Info\Actions\GetInfoAction;
use Marketplace\Core\Info\Resources\InfoResource;

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
