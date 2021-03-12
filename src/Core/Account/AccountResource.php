<?php

namespace Marketplace\Core\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
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
