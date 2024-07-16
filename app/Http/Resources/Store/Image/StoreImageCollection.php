<?php

namespace App\Http\Resources\Store\Image;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreImageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => $this->collection
        ];
    }
}
