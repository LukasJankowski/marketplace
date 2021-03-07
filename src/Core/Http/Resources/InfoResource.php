<?php


namespace Marketplace\Core\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class InfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param mixed $data
     * @return array
     */
    public function toArray(mixed $data): array
    {
        return parent::toArray($data);
    }
}
