<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.07.24
 * Time: 15:15
 */

namespace App\Http\Requests\Wallpaper;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Models\Gallery;
use App\Models\User;

class ShowRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        if ($this->checkAccess(RulesEnum::SHOW_WALLPAPER)) {
            /** @var Gallery $gallery */
            $gallery = $this->route('wallpaper');

            if (is_null($gallery->user_id) && is_null($gallery->device_uuid)) {
                return true;
            }
            $user = $this->user();
            if ($user instanceof User) {
                return $gallery->user_id === $user->id;
            }

            return $gallery->device_uuid === $user->uuid;
        }

        return false;
    }
    protected function getDtoClass(): ?string
    {
        return null;
    }
}
