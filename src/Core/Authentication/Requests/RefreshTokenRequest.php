<?php

namespace Marketplace\Core\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Marketplace\Foundation\Requests\RequestHelperTrait;

class RefreshTokenRequest extends FormRequest
{
    use RequestHelperTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [];
    }
}
