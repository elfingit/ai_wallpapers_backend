<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->id,
            'email' => $resource->email,
            'role' => $resource->role->title,
            'balance' => $resource->balance?->balance ?? '0.00',
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
