<?php

namespace Marketplace\Core\Data\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Marketplace\Core\Data\Account\AccountResource;
use Marketplace\Foundation\Services\TypeService;

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
            'account' => AccountResource::make($this['account']),
        ];
    }
}
