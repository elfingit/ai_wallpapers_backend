<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;
use App\Library\Gallery\Dto\AddDto;


class AddRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::ADD_FILE_TO_GALLERY);
    }

    protected function getDtoClass(): ?string
    {
        return AddDto::class;
    }
}
