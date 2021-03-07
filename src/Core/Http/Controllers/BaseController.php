<?php


namespace Marketplace\Core\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Routing\ResponseFactory;

class BaseController extends Controller
{
    /**
     * BaseController constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(protected ResponseFactory $factory) {}
}
