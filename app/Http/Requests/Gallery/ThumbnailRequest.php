<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class ThumbnailRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $gallery = $this->route('pic');
        $user = $this->user();
        return $this->checkAccess(RulesEnum::THUMBNAIL_OF_PICTURE)
            || $gallery->user_id === $user->id;
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
