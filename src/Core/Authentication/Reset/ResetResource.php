<?php

namespace Marketplace\Core\Authentication\Reset;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResetResource extends JsonResource
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
            'success' => true,
            'email' => $this['email'],
        ];
    }
}
