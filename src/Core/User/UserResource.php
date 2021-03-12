<?php

namespace Marketplace\Core\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Marketplace\Core\Account\AccountResource;
use Marketplace\Core\Type\TypeService;

class UserResource extends JsonResource
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
            'id' => $this['id'],
            'email' => $this['email'],
            'type' => TypeService::getKeyByClass($this['type']),
            'verified' => (bool) $this['email_verified_at'],
            'account' => AccountResource::make($this['account']),
        ];
    }
}
