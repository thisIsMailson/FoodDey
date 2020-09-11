<?php

namespace App\Http\Resources\Storage;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {        
        return [
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'capacity' => $this->capacity,
            'availableCapacity' => $this->available_capacity,
            'isAvailable' => $this->isAvailable(),
            'price' => number_format($this->storagePrice->price,2),
            'currency' => $this->storagePrice->currency,
            'owner' => $this->owner->name
        ];
    }
}
