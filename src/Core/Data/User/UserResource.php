<?php

namespace Marketplace\Core\Data\User;

use Illuminate\Http\Resources\Json\JsonResource;
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
            'username' => $this['username'],
            'email' => $this['email'],
            'type' => TypeService::getKeyByClass($this['type']),
        ];
    }
}
