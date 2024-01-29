<?php

namespace App\Http\Resources\Gallery;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Gallery $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'prompt' => $resource->prompt,
            'locale' => $resource->locale,
            'tags' => $resource->tags->pluck('title')->toArray(),
        ];
    }
}
