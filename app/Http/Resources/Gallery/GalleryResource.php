<?php

namespace App\Http\Resources\Gallery;

use App\Http\Controllers\Api\V1\WallpaperController;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Core\Utils\Utils;
use App\Models\Gallery;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    private ?string $warn_code = null;
    public function __construct(array | Gallery | \stdClass $resource)
    {
        if (is_array($resource)) {
            parent::__construct($resource['gallery']);
            $this->warn_code = $resource['warn_code'];
        } else {
            parent::__construct($resource);
        }
    }

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
            $this->mergeWhen(
                $this->canSeeLocale($resource, $user),
                fn() => ['locale' => $resource->locale],
            ),
            $this->mergeWhen(isset($resource->tags), fn() => ['tags' => $resource->tags->pluck('title')]),
            'thumbnail_url' => Utils::buildImageUrl($resource->id, 'thumbnail'),
            'download_url' => Utils::buildImageUrl($resource->id, 'download'),
            'user_id' => $resource->user_id,
            'device_uuid' => $resource->device_uuid,
        ];

        return $data;
    }

    private function canSeePrompt(Gallery | \stdClass $gallery, User | UserDevice $user): bool
    {
        if ($user instanceof UserDevice) {
            return false;
        }

        return $user->tokenCan(RulesEnum::PICTURE_PROMPT->value())
            || $gallery->user_id === $user->id;
    }

    private function canSeeLocale(Gallery | \stdClass $gallery, User | UserDevice $user): bool
    {
        if ($user instanceof UserDevice) {
            return false;
        }

        return $user->tokenCan(RulesEnum::PICTURE_LOCALE->value());
    }

    public function with($request): array
    {
        $clazz = get_class(\Route::getCurrentRoute()->getController());

        if ($clazz == WallpaperController::class) {
            $meta = [
                'meta' => [
                    'balance' => $this->getOwnerBalance($request->user())
                ]
            ];

            if (!is_null($this->warn_code)) {
                $meta['meta']['warn_code'] = $this->warn_code;
            }

            return $meta;
        }

        return parent::with($request);
    }

    private function getOwnerBalance(User | UserDevice $user): float
    {
        if ($user instanceof User) {
            return $user->balance->balance;
        } else if ($user instanceof UserDevice) {
            return $user->balance;
        }

        return 0.0;
    }
}
