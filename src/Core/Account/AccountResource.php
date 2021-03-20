<?php

namespace Marketplace\Core\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array<string, string>
     */
    public function toArray($request): array
    {
        return [
            'salutation' => $this['salutation'],
            'first_name' => $this['first_name'],
            'last_name' => $this['last_name'],
            'phone' => $this['phone'],
        ];
    }
}
