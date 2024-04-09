<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;


class DeleteRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::DELETE_FILE_FROM_GALLERY);
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
