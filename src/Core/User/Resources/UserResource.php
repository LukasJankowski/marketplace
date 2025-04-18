<?php

namespace Marketplace\Core\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Marketplace\Core\Account\AccountResource;
use Marketplace\Core\Authorization\RoleService;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'email' => $this['email'],
            'role' => RoleService::getSlugByRole($this['role']),
            'verified' => (bool) $this['email_verified_at'],
            'account' => AccountResource::make($this['account']),
        ];
    }
}
