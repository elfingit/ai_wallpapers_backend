<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;


class EditRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::EDIT_CATEGORY);
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
