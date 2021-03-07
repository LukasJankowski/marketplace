<?php


namespace Marketplace\Core\Contracts;


use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractFormRequest extends FormRequest
{
    /**
     * Get the DTO from the validated data.
     *
     * @return Dto
     */
    abstract public function getDto(): Dto;
}
