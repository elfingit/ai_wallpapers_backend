<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Gallery\Dto\UpdateDto;


class UpdateRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::UPDATE_FILE_IN_GALLERY);
    }

    protected function getDtoClass(): ?string
    {
        return UpdateDto::class;
    }
}
