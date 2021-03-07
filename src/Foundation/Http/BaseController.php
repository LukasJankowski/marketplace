<?php

namespace Marketplace\Foundation\Http;

use App\Http\Controllers\Controller;
use Illuminate\Routing\ResponseFactory;

abstract class BaseController extends Controller
{
    /**
     * BaseController constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(protected ResponseFactory $factory) {}
}
