<?php

namespace App\Http\Resources\Storage;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'location' => $this->location,
            'isAvailable' => $this->isAvailable(),
            'price' => number_format($this->storagePrice->price,2),
            'currency' => $this->storagePrice->currency,
            'href' => [
                'details' => route('storage.show', $this->id)
            ]
        ];
    }
}
