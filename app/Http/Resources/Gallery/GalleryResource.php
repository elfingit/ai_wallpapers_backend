<?php

namespace App\Http\Resources\Gallery;

use App\Library\Core\Acl\RulesEnum;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
        /** @var User $user */
        $user = $request->user();
        $data = [
            'id' => $resource->id,
            $this->mergeWhen(
                $this->canSeePrompt($resource, $user),
                fn() => ['prompt' => $resource->prompt],

            ),
            'tags' => $resource->tags->pluck('title'),
            'thumbnail_url' => route('gallery.thumbnail', ['pic' => $resource->id]),
            'download_url' => route('gallery.download', ['pic' => $resource->id]),
        ];

        return $data;
    }

    private function canSeePrompt(Gallery $gallery, User $user): bool
    {
        return $user->tokenCan(RulesEnum::PICTURE_PROMPT->value())
            || $gallery->user_id === $user->id;
    }
}
