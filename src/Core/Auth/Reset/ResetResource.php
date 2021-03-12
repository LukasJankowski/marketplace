<?php

namespace Marketplace\Core\Auth\Reset;

use Illuminate\Http\Resources\Json\JsonResource;

class ResetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'success' => true,
            'email' => $this['email'],
        ];
    }
}
