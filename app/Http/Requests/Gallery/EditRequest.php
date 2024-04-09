<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;


class EditRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::EDIT_FILE_IN_GALLERY);
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
