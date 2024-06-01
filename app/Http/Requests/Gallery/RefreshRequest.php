<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 1.06.24
 * Time: 14:21
 */

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class RefreshRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::REFRESH_PIC_GALLERY);
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
