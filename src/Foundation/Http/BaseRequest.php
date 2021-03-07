<?php

namespace Marketplace\Foundation\Http;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Foundation\Contracts\Dto;

abstract class BaseRequest extends FormRequest
{
    /**
     * Get the DTO from the validated data.
     *
     * @return Dto
     */
    abstract public function getDto(): Dto;
}
