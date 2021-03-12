<?php

namespace Marketplace\Foundation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'message' => $this['message'],
            'errors' => $this->when($this['errors'] !== [], $this['errors']),
        ];
    }
}
